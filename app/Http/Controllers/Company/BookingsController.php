<?php

namespace App\Http\Controllers\Company;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\BookingStoreRequest;
use App\Models\Admin\BookingStatus;
use App\Models\Admin\Company;
use App\Models\Admin\VehicleStatus;
use App\Models\Company\AdditionalService;
use App\Models\Company\Booking;
use App\Models\Company\Delivery;
use App\Models\Company\Insurance;
use App\Models\Company\Vehicle;
use App\Models\User;
use App\Notifications\BookingCancelNotification;
use App\Services\ActivityLogService;
use App\Services\BookingAvailabilityService;
use App\Services\BookingPricingService;
use App\Services\BookingStatusSyncService;
use App\Services\ForbiddenLogService;
use App\Services\VehiclePricingService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use League\CommonMark\Node\NodeIterator;
use Yajra\DataTables\Facades\DataTables;

class BookingsController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a listing of bookings or return datatable JSON (AJAX).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request){

        if (! auth()->user()->hasPermission('bookings.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'bookings.view_any', 'Can not view all bookings');
            return view('admin.errors.unauthorized');
        }

        if ($request->ajax()) {

            try {
                $bookings = Booking::with('company', 'vehicle', 'pickUpLocation', 'DropOffLocation', 'bookingStatus')
                    ->where('company_id', auth()->user()->company_id)
                    ->orderBy('id', 'desc');

                if ($request->filled('vehicle_title')) {
                    $vehicleTitle = $request->input('vehicle_title');
                    $bookings->whereHas('vehicle', function ($q) use ($vehicleTitle) {
                        $q->where('title', 'like', "%{$vehicleTitle}%");
                    });
                }

                if ($request->has('booking_status_id') && $request->booking_status_id != null) {
                    $filter = $request->get('booking_status_id');
                    $bookings->where('booking_status_id', $filter);
                }

                return DataTables::eloquent($bookings)
                    ->addIndexColumn()
                    ->editColumn('booking_code',function (Booking $booking){
                        return view('company.bookings.datatable.booking_code',compact('booking'));
                    })
                    ->addColumn('date_and_time',function (Booking $booking){
                        return view('company.bookings.datatable.date_and_time',compact('booking'));
                    })
                    ->addColumn('details',function (Booking $booking){
                        return view('company.bookings.datatable.details',compact('booking'));
                    })
                    ->addColumn('finance',function (Booking $booking){
                        return view('company.bookings.datatable.finance',compact('booking'));
                    })
                    ->addColumn('full_name',function (Booking $booking){
                        return view('company.bookings.datatable.full_name',compact('booking'));
                    })
                    ->addColumn('locations',function (Booking $booking){
                        return view('company.bookings.datatable.locations',compact('booking'));
                    })
                    ->addColumn('status',function (Booking $booking){

                        return view('company.bookings.datatable.status',compact(['booking']));
                    })
                    ->addColumn('vehicle',function (Booking $booking){
                        return view('company.bookings.datatable.vehicle',compact('booking'));
                    })
                    ->addColumn('actions', function (Booking $booking){
                        return view('company.bookings.datatable.actions',compact('booking'));
                    })
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('company.bookings.index');
    }
    /**
     * Display the detailed data of the specified booking.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function show($id)
    {
        if (! auth()->user()->hasPermission('bookings.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'bookings.view_any', 'Can not view all bookings');
            return view('admin.errors.unauthorized');
        }

        $company_id = auth()->user()->company_id;

        $booking = Booking::where('id',$id)
            ->where('company_id', $company_id)
            ->with(['insurance','additionalServices'])
            ->firstOrFail();

        $bookingArray = $booking->toArray();
        $bookingArray['additional_services'] = $booking->additionalServices->map(function($service) {
            return [
                'id' => $service->id,
                'quantity' => $service->pivot->quantity ?? 1,
                'price' => $service->pivot->price ?? $service->service_price,
            ];
        });

       if($booking->session_id)
       {
           $pricingDetails = app(\App\Services\BookingPricingService::class)->calculate($bookingArray, $booking->vehicle);

           $commissionAmount = round($pricingDetails['total_price'] * ($booking->vehicle->company->booking_fee_percentage / 100), 2);
       }
       else
       {
           $commissionAmount = '--';
       }

        return view('company.bookings.show.show')->with([
            'booking' => $booking,
            'commissionAmount' => $commissionAmount,
        ]);
    }

    /**
     * Show the form for creating a new booking.
     *
     * @return \Illuminate\View\View
     */

    public function create()
    {
        if (! auth()->user()->hasPermission('bookings.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'bookings.store', 'Can not create bookings');
            return view('admin.errors.unauthorized');
        }

        $vehicles = Vehicle::where('company_id',auth()->user()->company_id)->get();

        return view('company.bookings.create', [
            'vehicles' => $vehicles,
            ]
        );

    }

    /**
     * Store a newly created booking in storage.
     *
     * @param \App\Http\Requests\Company\BookingStoreRequest $request
     * @param \App\Services\VehiclePricingService $pricingService
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */

    public function store(BookingStoreRequest $request, VehiclePricingService $pricingService)
    {
        if (! auth()->user()->hasPermission('bookings.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'bookings.store', 'Can not create bookings');
            return view('admin.errors.unauthorized');
        }

        // Parse pickup + dropoff date & time
        $pickupDate = Carbon::createFromFormat('d-m-Y', $request->pickup_date);
        $dropoffDate = Carbon::createFromFormat('d-m-Y', $request->dropoff_date);

        $pickupTime = Carbon::createFromFormat('H:i', $request->pickup_time);
        $dropoffTime = Carbon::createFromFormat('H:i', $request->dropoff_time);

        // Build full timestamps
        $pickupDateTime = $pickupDate->copy()->setTimeFrom($pickupTime);
        $dropoffDateTime = $dropoffDate->copy()->setTimeFrom($dropoffTime);

        if ($pickupDateTime->gte($dropoffDateTime)) {
            return back()->withErrors(['dropoff_date' => 'Dropoff must be after pickup.'])->withInput();
        }

        // Load vehicle
        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        // Check availability
        if (!app(BookingAvailabilityService::class)->isVehicleAvailable($vehicle->id, $pickupDateTime, $dropoffDateTime)) {
            return back()->withErrors(['vehicle_id' => 'This vehicle is not available for these dates and times.'])
                ->withInput();
        }

        // Calculate total rental days (uses hours!)
        $totalHours = $pickupDateTime->diffInHours($dropoffDateTime);
        $days = max(1, ceil($totalHours / 24));

        // VEHICLE PRICING SERVICE
        // PASS 4 PARAMS NOW
        $pricing = $pricingService->calculate(
            $vehicle,
            $pickupDateTime,
            $dropoffDateTime,
            $days
        );

        // Generate booking code
        do {
            $booking_code = random_int(100000, 999999);
        } while (Booking::where('booking_code', $booking_code)->exists());

        // Format birthday
        $birthday = $request->birthday
            ? Carbon::createFromFormat('d-m-Y', $request->birthday)->format('Y-m-d')
            : null;


        $company_id = auth()->user()->company_id;

        // Create booking with base data
        $booking = Booking::create([
            'booking_code'              => $booking_code,
            'first_name'                => $request->first_name,
            'last_name'                 => $request->last_name,
            'birthday'                  => $birthday,
            'email'                     => $request->email,
            'phone'                     => $request->phone,
            'additional_phone'          => $request->additional_phone ?? null,
            'pickup_date'               => $pickupDate,
            'dropoff_date'              => $dropoffDate,
            'pickup_time'               => $request->pickup_time,
            'dropoff_time'              => $request->dropoff_time,
            'ways_of_contact'           => $request->ways_of_contact ?? null,
            'vehicle_id'                => $vehicle->id,
            'company_id'                => $company_id,
            'insurance_id'              => $request->insurance_id ?? null,
            'pickup_location'           => $request->pickup_location,
            'dropoff_location'          => $request->dropoff_location,
            'booking_status_id'         => BookingStatus::CONFIRMED,
            'notes'                     => $request->notes,
            'created_by'                => auth()->user()->id,

            // Pricing
            'days'                      => $pricing['total_days'],
            'daily_rate'                => $pricing['final_daily_rate'],
            'base_daily_rate'           => $pricing['base_daily_rate'],
            'applied_tariff_multiplier' => $pricing['tariff_multiplier'],

            // To be filled later
            'addons_total'              => 0,
            'insurance_total'           => 0,
            'deliveries_total'          => 0,
            'total_price'               => 0,
            'commission_amount'         => 0,
        ]);

        // Attach additional services
        $additionalServices = $request->additional_services;

        if (is_string($additionalServices)) {
            $additionalServices = json_decode($additionalServices, true);
        }

        if (is_array($additionalServices)) {
            $pivotData = [];
            foreach ($additionalServices as $service) {
                $serviceModel = AdditionalService::find($service['id']);
                if (!$serviceModel) continue;

                $pivotData[$service['id']] = [
                    'quantity' => $service['quantity'] ?? 1,
                    'price'    => $service['price'] ?? 0,
                ];
            }

            $booking->additionalServices()->attach($pivotData);
        }

        // Full booking pricing
        $pricingDetails = app(BookingPricingService::class)
            ->calculate($request->all(), $vehicle);

        $commissionPercentage = $vehicle->company->booking_fee_percentage;
        $commissionAmount = round($pricingDetails['total_price'] * ($commissionPercentage / 100), 2);

        $booking->update([
            'addons_total'     => $pricingDetails['addons_total'],
            'insurance_total'  => $pricingDetails['insurance_total'],
            'deliveries_total' => $pricingDetails['deliveries_total'],
            'total_price'      => $pricingDetails['total_price'],
            'commission_amount' => $commissionAmount,
        ]);



        // Sync status with vehicle
        app(\App\Services\BookingStatusSyncService::class)
            ->syncVehicleStatus($booking);

        // Notifications
        $company_admin = User::where('user_type', \App\Enums\UserTypesEnum::COMPANY_ADMIN)
            ->where('company_id', auth()->user()->company_id)
            ->get();

        Notification::send($company_admin, new \App\Notifications\BookingCreatedWebController($booking));

        FlashNotification::success(__('master.success'), __('master.created_successfully'));

        return ActionJsonResponse::make(true, route('company.bookings.index', ['id' => $booking->id]))->response();
    }

    /**
     * Mark the booking as picked up and sync vehicle/booking statuses.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function pickup(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        $oldBookingStatuss=$booking->booking_status_id;
        $oldVehicleStatuss=$booking->vehicle->vehicle_status_id;

        app(BookingStatusSyncService::class)->pickup($booking);

        $booking->vehicle->refresh();

        if($oldBookingStatuss === BookingStatus::CONFIRMED && $booking->booking_status_id === BookingStatus::ACTIVE &&
            $oldVehicleStatuss === VehicleStatus::BOOKED && $booking->vehicle->vehicle_status_id === VehicleStatus::RENTED)
        {
            $admin=User::where('user_type', UserTypesEnum::COMPANY_ADMIN)->where('company_id',auth()->user()->company_id)->get();
            Notification::send($admin,new \App\Notifications\StatusChangedPickUp($booking));
        }
        return response()->json(['success' => true]);
    }

    /**
     * Mark the booking as dropped off and sync vehicle/booking statuses.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dropoff(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        $oldBookingStatus=$booking->booking_status_id;
        $oldVehicleStatus=$booking->vehicle->vehicle_status_id;

        app(BookingStatusSyncService::class)->dropoff($booking);

        $booking->vehicle->refresh();

        if($oldBookingStatus === BookingStatus::ACTIVE && $booking->booking_status_id === BookingStatus::COMPLETED &&
            $oldVehicleStatus === VehicleStatus::RENTED && $booking->vehicle->vehicle_status_id === VehicleStatus::AVAILABLE)
        {
            $admin=User::where('user_type', UserTypesEnum::COMPANY_ADMIN)->where('company_id',auth()->user()->company_id)->get();
            Notification::send($admin,new \App\Notifications\StatusChangedDropoff($booking));
        }
        return response()->json(['success' => true]);
    }
    /**
     * Cancel a booking if the user has permission and conditions are met.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cancellation(Request $request)
    {
        if (!auth()->user()->hasPermission('bookings.cancel')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'bookings.cancel', 'Does not have permissions to cancel this booking.');

            return [
                'status' => 2,
                'message' => 'This booking is not active.'
            ];
        }

        $request->validate([
            'data.delete_id' => 'required|integer|exists:bookings,id'
        ]);

        $cancelledId = $request->input('data.delete_id');

        try {
            DB::beginTransaction();

            $booking = Booking::where('id', $cancelledId)
                ->where('created_by',auth()->user()->id)
                ->whereIn('booking_status_id',[1, 2])
                ->first();


            if (!$booking) {
                DB::rollBack();
                return [
                    'status' => 1,
                    'message' => 'This booking cannot be deleted.'
                ];
            }


            $booking->update([
                'booking_status_id' => BookingStatus::CANCELLED,
            ]);

            $vehicle = $booking->vehicle;
            if($vehicle){
                $vehicle->update([
                    'vehicle_status_id' => VehicleStatus::AVAILABLE ,
                ]);
            }


            DB::commit();

            $company_admins=User::where('user_type', UserTypesEnum::COMPANY_ADMIN)->where('company_id',auth()->user()->company_id)->get();
            Notification::send($company_admins,new BookingCancelNotification($booking));

            $this->activityLogService->storeActivityLog(
                'Cancelled Booking. Booking ID: ' . $cancelledId,
                1,
                'BookingsController@cancel',
                'delete'
            );

            return [
                'status' => 1,
                'message' => 'Booking cancelled successfully.'
            ];


        } catch (\Exception $e) {
            report($e);
            DB::rollBack();

            return [
                'status' => 0,
                'message' => 'Something went wrong. Please try again later.'
            ];
        }

    }
    /**
     * Display the bookings calendar view.
     *
     * @return \Illuminate\View\View
     */

    public function calendar()
    {
        return view('company.bookings.calendar');
    }
    /**
     * Return booking calendar data as JSON for FullCalendar.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function calendarData()
    {
        $company_id = auth()->user()->company_id;

        $bookings = Booking::where('company_id', $company_id)
            ->with([
                'vehicle:id,title',
                'bookingStatus:id,title_en,text_color,background_color',
            ])
            ->get()
            ->map(function ($booking) {
                return [
                    'id'    => $booking->id,
                    'title' => $booking->vehicle->title,
                    'start' => \Carbon\Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time)->toIso8601String(),
                    'end'   => \Carbon\Carbon::parse($booking->dropoff_date . ' ' . $booking->dropoff_time)->toIso8601String(),
                    'status'=> $booking->bookingStatus->title_en,
                    'color'     => $booking->bookingStatus->text_color,
                    'extendedProps' => [
                        'first_name'      => $booking->first_name ?? '',
                        'last_name'       => $booking->last_name ?? '',
                        'email'           => $booking->email ?? '',
                        'phone'           => $booking->phone ?? '',
                        'status_color'    => $booking->bookingStatus->text_color,
                        'status_bg'       => $booking->bookingStatus->background_color,
                        'pickup_time'     => $booking->pickup_time ? \Carbon\Carbon::parse($booking->pickup_time)->format('H:i') : null,
                        'dropoff_time'   => $booking->dropoff_time ? \Carbon\Carbon::parse($booking->dropoff_time)->format('H:i') : null,
                    ]
                ];
            });

        return response()->json($bookings);
    }
}