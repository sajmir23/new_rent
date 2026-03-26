<?php

namespace App\Http\Controllers;

use App\Models\Admin\BookingStatus;
use App\Models\Admin\City;
use App\Models\Admin\VehicleCategory;
use App\Models\Company\AdditionalService;
use App\Models\Company\Booking;
use App\Models\Company\Delivery;
use App\Models\Company\Insurance;
use App\Models\Company\SeasonalPrice;
use App\Models\Company\Tariff;
use App\Models\Company\Vehicle;
use App\Services\BookingAvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        $categories = VehicleCategory::where('status', true)->get();
        $cities = City::orderBy('name', 'asc')->get();
        $deliveries = Delivery::orderBy('city_id')->orderBy('price')->get();

        $vehicles = Vehicle::baseData()->latest()->paginate(6);

        return view('welcomee', compact('categories', 'cities','vehicles','deliveries'));
    }

    public function searchCars(Request $request)
    {
        $filters = $request->all();

        $vehicles = Vehicle::baseData()->filter($filters)->paginate(6);

        $categories = VehicleCategory::where('status', true)->get();
        $cities = City::orderBy('name', 'asc')->get();

        $totalDays = 1;
        if ($request->filled(['pickupDate', 'dropoffDate', 'pickupTime', 'dropoffTime'])) {
            $start = Carbon::parse($request->pickupDate . ' ' . $request->pickupTime);
            $end = Carbon::parse($request->dropoffDate . ' ' . $request->dropoffTime);

            if ($end->greaterThan($start)) {
                $diffMinutes = $start->diffInMinutes($end);
                $diffDays = floor($diffMinutes / (24 * 60));
                $remainder = $diffMinutes % (24 * 60);

                if ($remainder >= 15) {
                    $diffDays++;
                }
                $totalDays = $diffDays + 1;
            }
        }
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.vehicle_list', compact('vehicles'))->render(),
                'total' => $vehicles->total(),
                'current_count' => $vehicles->count(),
                'next_page' => $vehicles->nextPageUrl(),
                'has_more' => $vehicles->hasMorePages()
            ]);
        }

        return view('welcomee', compact('vehicles', 'categories', 'cities', 'totalDays'));
    }

    public function getVehicleBookingDetails(Request $request, $id)
    {
        $vehicle = Vehicle::baseData()->findOrFail($id);

        $pickupDate = $request->query('pickupDate');
        $dropoffDate = $request->query('dropoffDate');
        $pickupTime = $request->query('pickupTime');
        $dropoffTime = $request->query('dropoffTime');

        $bookedDates = Booking::where('vehicle_id', $vehicle->id)
            ->whereIn('booking_status_id', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE, BookingStatus::PENDING,BookingStatus::COMPLETED])
            ->where('dropoff_date', '>=', now()->toDateString())
            ->get(['pickup_date', 'dropoff_date'])
            ->map(function ($booking) {
                return [
                    'from' => \Carbon\Carbon::parse($booking->pickup_date)->format('Y-m-d'),
                    'to'   => \Carbon\Carbon::parse($booking->dropoff_date)->format('Y-m-d')
                ];
            })->toArray();


        $hasConflict = false;
        if ($pickupDate && $dropoffDate) {
            $reqStart = \Carbon\Carbon::parse("$pickupDate $pickupTime");
            $reqEnd = \Carbon\Carbon::parse("$dropoffDate $dropoffTime");

            $hasConflict = !app(BookingAvailabilityService::class)
                ->isVehicleAvailable($vehicle->id, $reqStart, $reqEnd);
        }

        $totalDays = $request->query('days', 1);

        $insurances = Insurance::where('company_id', $vehicle->company_id)->get();

        $additionalServices = AdditionalService::where('company_id', $vehicle->company_id)->get();

        $tariffs = Tariff::where('company_id', $vehicle->company_id)->get();

        $seasonalPrices = SeasonalPrice::where('company_id', $vehicle->company_id)->get();

        if ($request->ajax()) {

            return view('partials.booking_modal_content', with([
                    'vehicle' => $vehicle,
                    'totalDays' => $totalDays ,
                    'insurances' => $insurances,
                    'additionalServices' => $additionalServices,
                    'tariffs' => $tariffs,
                    'seasonalPrices' =>$seasonalPrices,
                    'bookedDates'=>$bookedDates,
                    'hasConflict' =>$hasConflict,])
            )->render();
        }
        abort(404);
    }
}
