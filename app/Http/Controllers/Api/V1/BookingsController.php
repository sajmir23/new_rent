<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BookingsStoreRequest;
use App\Models\Admin\BookingStatus;
use App\Models\Admin\PaymentStatus;
use App\Models\Company\AdditionalService;
use App\Models\Company\Booking;
use App\Models\Company\Vehicle;
use App\Models\User;
use App\Notifications\BookingCreatedApiController;
use App\Notifications\BookingPaidApiController;
use App\Services\BookingAvailabilityService;
use App\Services\BookingPricingService;
use App\Services\BookingStatusSyncService;
use App\Services\VehiclePricingService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;


class BookingsController extends Controller
{
    /* public function store(BookingsStoreRequest $request, VehiclePricingService $pricingService)
     {
         // Parse dates and times separately
         $pickupDate = Carbon::createFromFormat('d-m-Y', $request->pickup_date)->startOfDay();
         $dropoffDate = Carbon::createFromFormat('d-m-Y', $request->dropoff_date)->startOfDay();

         $pickupTime = Carbon::createFromFormat('H:i', $request->pickup_time);
         $dropoffTime = Carbon::createFromFormat('H:i', $request->dropoff_time);

         // Combine for availability check
         $pickupDateTime = $pickupDate->copy()->setTimeFrom($pickupTime);
         $dropoffDateTime = $dropoffDate->copy()->setTimeFrom($dropoffTime);

         // Find vehicle
         $vehicle = Vehicle::findOrFail($request->vehicle_id);

         // Check availability
         if (!app(BookingAvailabilityService::class)->isVehicleAvailable($vehicle->id, $pickupDateTime, $dropoffDateTime)) {
             return back()
                 ->withErrors(['vehicle_id' => 'This vehicle is not available for these dates and times.'])
                 ->withInput();
         }

         // Format birthday
         $birthday = $request->birthday
             ? Carbon::createFromFormat('d-m-Y', $request->birthday)->format('Y-m-d')
             : null;

         // Calculate number of days
         $days = $pickupDate->diffInDays($dropoffDate) + 1;
         if ($days < 1) {
             return response()->json(['error' => 'Dropoff date must be after pickup date'], 422);
         }

         // Calculate pricing
         $pricing = $pricingService->calculate($vehicle, $pickupDate, $dropoffDate);

         // Generate unique booking code
         do {
             $bookingCode = random_int(100000, 999999);
         } while (Booking::where('booking_code', $bookingCode)->exists());

         // Create booking
         $booking = Booking::create([
             'booking_code'      => $bookingCode,
             'first_name'        => $request->first_name,
             'last_name'         => $request->last_name,
             'birthday'          => $birthday,
             'email'             => $request->email,
             'phone'             => $request->phone,
             'additional_phone'  => $request->additional_phone ?? null,
             'pickup_date'       => $pickupDate,
             'dropoff_date'      => $dropoffDate,
             'pickup_time'       => $request->pickup_time,
             'dropoff_time'      => $request->dropoff_time,
             'pickup_location'   => $request->pickup_location,
             'dropoff_location'  => $request->dropoff_location,
             'ways_of_contact'   => $request->ways_of_contact ?? null,
             'vehicle_id'        => $vehicle->id,
             'company_id'        => $vehicle->company_id,
             'booking_status_id' => BookingStatus::CONFIRMED,
             'insurance_id'      => $request->insurance_id,
             'notes'             => $request->notes ?? null,
             'days'                   => $pricing['total_days'],
             'daily_rate'             => $pricing['final_daily_rate'],
             'base_daily_rate'        => $pricing['base_daily_rate'],
             'applied_tariff_multiplier'  => $pricing['tariff_multiplier'],
             'deliveries_total'       => 0,
             'total_price'            => 0,
             'addons_total'           => 0,
             'insurance_total'        => 0,
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
                     'quantity' => $service['quantity'],
                 ];
             }
             $booking->additionalServices()->attach($pivotData);
         }

         // Calculate addons, insurance, total
         $pricingDetails = app(BookingPricingService::class)
             ->calculate($request->all(), $vehicle);

         $booking->update([
             'addons_total'     => $pricingDetails['addons_total'],
             'insurance_total'  => $pricingDetails['insurance_total'],
             'deliveries_total' => $pricingDetails['deliveries_total'],
             'total_price'      => $pricingDetails['total_price'],
         ]);

         // Sync vehicle booking status
         app(\App\Services\BookingStatusSyncService::class)
             ->syncVehicleStatus($booking);

         $company_admin = User::where('user_type', \App\Enums\UserTypesEnum::COMPANY_ADMIN)->where('company_id',$vehicle->company_id)->get();

         $system_admin = User::where('user_type',UserTypesEnum::SYSTEM_ADMIN)->get();

         $merged = $company_admin->merge($system_admin);

         Notification::send($merged,new \App\Notifications\BookingCreatedApiController($booking));

         return response()->json([
             'success' => true,
             'booking' => $booking->load('insurance', 'additionalServices'),
         ]);
     }*/

    /**
     * Store a new booking, calculate pricing, and create a Stripe checkout session.
     *
     * @param BookingsStoreRequest $request
     * @param VehiclePricingService $pricingService
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(BookingsStoreRequest $request, VehiclePricingService $pricingService)
    {
        $pickupDate = Carbon::createFromFormat('d-m-Y', $request->pickup_date)->startOfDay();
        $dropoffDate = Carbon::createFromFormat('d-m-Y', $request->dropoff_date)->startOfDay();

        $pickupTime = Carbon::createFromFormat('H:i', $request->pickup_time);
        $dropoffTime = Carbon::createFromFormat('H:i', $request->dropoff_time);

        $pickupDateTime = $pickupDate->copy()->setTimeFrom($pickupTime);
        $dropoffDateTime = $dropoffDate->copy()->setTimeFrom($dropoffTime);

        if ($pickupDateTime ->gte($dropoffDateTime))
        {
            return response()->json(['error' => 'Dropoff datetime must be after pickup datetime'], 422);
        }

        $vehicle = Vehicle::findOrFail($request->vehicle_id);


        if (!app(BookingAvailabilityService::class)->isVehicleAvailable($vehicle->id, $pickupDateTime, $dropoffDateTime)) {
            return response()->json(['error' =>'This vehicle is not available for these dates and times.'],422);
        }

        $days = $pickupDateTime->diffInDays($dropoffDateTime) + 1;

        $pricing = $pricingService->calculate($vehicle, $pickupDateTime, $dropoffDateTime, $days);

        do {
            $booking_code = random_int(100000, 999999);
        } while (Booking::where('booking_code', $booking_code)->exists());

        $tempKey = 'booking_temp_' . $booking_code;

        $depositPrice = $booking->insurance->deposit_price ?? 0;

        $pricingDetails = app(BookingPricingService::class)->calculate($request->all(), $vehicle);
        $commissionPercentage = $vehicle->company->booking_fee_percentage;
        $commissionAmount = round(($pricingDetails['total_price'] - $depositPrice) * ($commissionPercentage / 100), 2);

        cache()->put($tempKey, [
            'booking_data' => array_merge($request->all(),[
                'commission_amount' => $commissionAmount
            ]),
            'pricing_data' => $pricing,
            'booking_code' => $booking_code,
        ], now()->addMinutes(150));


        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $checkout_session = $stripe->checkout->sessions->create([
            'customer_email' => $request->email,
            'line_items' => [[
                'price_data' => [
                    'currency' => config('app.currency', 'eur'),
                    'product_data' => [
                        'name' => "Commission - {$vehicle->title}",
                        'description' => "Commission for vehicle with VIN: {$vehicle->vin} and PLATE: {$vehicle->plate}",
                    ],
                    'unit_amount' => intval($commissionAmount * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'invoice_creation' => ['enabled' => true],
            'success_url' => route('api.bookings.success') . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('api.bookings.cancel') ."?session_id={CHECKOUT_SESSION_ID}",
            'payment_intent_data' => [
                'metadata' => [
                    'vehicle_id' => $vehicle->id,
                    'company_id' => $vehicle->company_id,
                    'customer_email' => $request->email,
                ]
            ]
        ]);

        $finalKey = 'booking_' . $checkout_session->id;
        $cachedData = cache()->get($tempKey);
        cache()->put($finalKey, $cachedData, now()->addMinutes(150));

        cache()->forget($tempKey);

        return response()->json([
            'success' => true,
            'checkout_url'=>$checkout_session->url,
            'session_id' => $checkout_session->id,
            'booking_code' => $booking_code,
            'pricing'=> $pricing,
            'booking_data'=>$request->all(),
        ]);
    }

    /**
     * Handle successful Stripe payment and create the final booking record.
     *
     * @param Request $request
     */

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return response()->json(['error' => 'Missing Stripe session ID.'], 400);
        }

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return response()->json(['error' => 'Payment not completed.'], 422);
        }

        $cacheKey = 'booking_' . $sessionId;

        $cacheData = cache()->get($cacheKey);

        if (!$cacheData) {
            return response()->json(['error' => 'Booking session expired or invalid.'], 404);
        }

        $bookingData = $cacheData['booking_data'];
        $pricing = $cacheData['pricing_data'];
        $booking_code = $cacheData['booking_code'];

        $vehicle = Vehicle::findOrFail($bookingData['vehicle_id']);

        $company_id = $vehicle->company_id;

        $booking = DB::transaction(function() use ($sessionId, $bookingData, $pricing, $booking_code, $vehicle, $company_id)
        {
            $existing_booking = Booking::where('session_id', $sessionId)->first();

            if ($existing_booking)
            {
                return $existing_booking;
            }

            $pickup = Carbon::createFromFormat('d-m-Y', $bookingData['pickup_date'])->startOfDay();
            $dropoff = Carbon::createFromFormat('d-m-Y', $bookingData['dropoff_date'])->startOfDay();

            $pickupTime = Carbon::createFromFormat('H:i', $bookingData['pickup_time']);
            $dropoffTime = Carbon::createFromFormat('H:i', $bookingData['dropoff_time']);

            $pickupDateTime = $pickup->copy()->setTimeFrom($pickupTime);
            $dropoffDateTime = $dropoff->copy()->setTimeFrom($dropoffTime);


            $conflict = Booking::where('vehicle_id',$vehicle->id)
                ->where(function ($query) use ($pickupDateTime, $dropoffDateTime) {
                    $query->whereRaw(
                        '(pickup_date + INTERVAL TIME_TO_SEC(pickup_time) SECOND) < ? AND (dropoff_date + INTERVAL TIME_TO_SEC(dropoff_time) SECOND) > ?',
                        [$dropoffDateTime, $pickupDateTime]
                    );
                })
                ->lockForUpdate()
                  ->exists();

              if($conflict)
              {
                  throw new Exception('Booking conflict detected.', 422);
              }


            $birthday = !empty($bookingData['birthday']) ? Carbon::createFromFormat('d-m-Y', $bookingData['birthday'])->format('Y-m-d') : null;

            $booking = Booking::create([
                'booking_code'              => $booking_code,
                'first_name'                => $bookingData['first_name'],
                'last_name'                 => $bookingData['last_name'],
                'birthday'                  => $birthday,
                'email'                     => $bookingData['email'],
                'phone'                     => $bookingData['phone'],
                'additional_phone'          => $bookingData['additional_phone'] ?? null,
                'total_price'               => 0,
                'addons_total'              => 0,
                'pickup_date'               => $pickup,
                'dropoff_date'              => $dropoff,
                'pickup_time'               => $bookingData['pickup_time'],
                'dropoff_time'              => $bookingData['dropoff_time'],
                'ways_of_contact'           => $bookingData['ways_of_contact'] ?? null,
                'vehicle_id'                => $vehicle->id,
                'company_id'                => $company_id,
                'insurance_id'              => $bookingData['insurance_id'] ?? null,
                'pickup_location'           => $bookingData['pickup_location'],
                'dropoff_location'          => $bookingData['dropoff_location'],
                'booking_status_id'         => BookingStatus::CONFIRMED,
                'payment_status_id'         => PaymentStatus::PAID,
                'commission_amount'          => $bookingData['commission_amount'],
                'deliveries_total'          => 0,
                'days'                      => $pricing['total_days'],
                'daily_rate'                => $pricing['final_daily_rate'],
                'base_daily_rate'           => $pricing['base_daily_rate'],
                'applied_tariff_multiplier' => $pricing['tariff_multiplier'],
                'insurances_total'          => 0,
                'notes'                     => $bookingData['notes'] ?? null,
                'session_id'                => $sessionId,
            ]);

            $additionalServices = $bookingData['additional_services'] ?? [];

            if (!empty($additionalServices)) {
                $services = is_string($additionalServices)
                    ? json_decode($additionalServices, true)
                    : $additionalServices;

                if (is_array($services)) {
                    $pivotData = [];
                    foreach ($services as $service) {
                        $serviceModel = AdditionalService::where('id', $service['id'])
                            ->where('company_id', $company_id)
                            ->first();

                        if (!$serviceModel) continue;

                        $pivotData[$service['id']] = [
                            'quantity' => $service['quantity'] ?? 1,
                            'price' => $serviceModel->service_price  ?? 0,
                        ];
                    }
                    $booking->additionalServices()->attach($pivotData);
                }
            }

            $pricingDetails = app(BookingPricingService::class)->calculate($bookingData, $vehicle);

            $booking->update([
                'addons_total' => $pricingDetails['addons_total'],
                'insurance_total' => $pricingDetails['insurance_total'],
                'deliveries_total' => $pricingDetails['deliveries_total'],
                'total_price' => $pricingDetails['total_price'],
            ]);

            app(BookingStatusSyncService::class)->syncVehicleStatus($booking);

            return $booking;
        });

        $companyAdmins = User::where('user_type', \App\Enums\UserTypesEnum::COMPANY_ADMIN)
            ->where('company_id', $company_id)
            ->get();
        $systemAdmins = User::where('user_type', \App\Enums\UserTypesEnum::SYSTEM_ADMIN)->get();

        Notification::send($companyAdmins->merge($systemAdmins), new BookingCreatedApiController($booking));

        Notification::route('mail', $booking->email)->notify(new BookingPaidApiController($booking));

        cache()->forget($cacheKey);

        $stripeInvoiceUrl = null;
        if (!empty($session->invoice)) {
            $invoice = $stripe->invoices->retrieve($session->invoice);
            $stripeInvoiceUrl = $invoice->invoice_pdf;
           /* $stripeInvoiceUrl = $invoice->hosted_invoice_url;*/  //ketu shkarkon invoice edhe receipt

        }

        $booking->load('vehicle', 'insurance', 'additionalServices');

        if ($request->wantsJson()) {
            return response()->json([
                'booking' => $booking,
                'success' => true,
                'message' => 'Booking created successfully.',
            ]);
        }

        return view('booking_success', compact('booking','stripeInvoiceUrl'));
    }

    /**
     * Cancel a booking session and remove cache.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function cancel(Request $request)
    {
        $sessionId = $request->get('session_id');
        $status = 'unknown';
        $message = 'Payment was not successful.';

        try {
            if ($sessionId) {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $session = $stripe->checkout->sessions->retrieve($sessionId);
                $status = $session->status ?? 'unknown';

                if (in_array($status, ['canceled', 'failed', 'incomplete'])) {
                    $message = 'Payment failed or was blocked by Stripe. Please contact our support team.';
                }
            }
        } catch (\Exception $e) {
            Log::warning('Stripe Checkout Error: ' . $e->getMessage());
        }

        if ($sessionId) {
            cache()->forget('booking_' . $sessionId);
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}