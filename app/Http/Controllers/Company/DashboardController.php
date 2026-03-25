<?php

namespace App\Http\Controllers\Company;

use App\Enums\LocalesEnum;
use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\BookingStatus;
use App\Models\Admin\VehicleStatus;
use App\Models\Company\Booking;
use App\Models\Company\Vehicle;
use App\Models\User;
use App\Support\FlashNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the company dashboard with vehicle, booking, and staff statistics.
     *
     * Provides:
     * - Staff counts and lists
     * - Vehicle status counts
     * - Booking status counts
     * - Recent bookings and today's pickups/dropoffs
     * - Vehicles reused on the same day
     * - Monthly and yearly booking summaries
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $company_id = $user->company_id;

        // Company Staff
        $total_staff = User::where('user_type', UserTypesEnum::STAFF)
            ->where('company_id', $company_id)
            ->count();

        $stafflists = User::where('user_type', UserTypesEnum::STAFF)
            ->where('company_id', $company_id)
            ->select('first_name', 'last_name', 'email', 'phone_number')
            ->get();

        // Vehicles Status Counts
        $vehicleCounts = Vehicle::where('company_id', $company_id)
            ->select('vehicle_status_id', DB::raw('count(*) as total'))
            ->groupBy('vehicle_status_id')
            ->pluck('total','vehicle_status_id');

        $all_vehicles = array_sum($vehicleCounts->toArray());
        $available_vehicles = $vehicleCounts[1] ?? 0;
        $booked_vehicles = $vehicleCounts[2] ?? 0;
        $maintenance_vehicles = $vehicleCounts[3] ?? 0;
        $inactive_vehicles = $vehicleCounts[4] ?? 0;
        $reserved_vehicles = $vehicleCounts[5] ?? 0;

        $available_status = VehicleStatus::find(1);
        $booked_status = VehicleStatus::find(2);
        $maintenance_status = VehicleStatus::find(3);
        $inactive_status = VehicleStatus::find(4);
        $rented_status = VehicleStatus::find(5);

        // Bookings Status Counts
        $bookingCounts = Booking::where('company_id', $company_id)
            ->select('booking_status_id', DB::raw('count(*) as total'))
            ->groupBy('booking_status_id')
            ->pluck('total','booking_status_id');

        $all_bookings = array_sum($bookingCounts->toArray());
        $pending_bookings = $bookingCounts[1] ?? 0;
        $confirmed_bookings = $bookingCounts[2] ?? 0;
        $active_bookings = $bookingCounts[3] ?? 0;
        $completed_bookings = $bookingCounts[4] ?? 0;
        $cancelled_bookings = $bookingCounts[5] ?? 0;

        $pending_status = BookingStatus::find(1);
        $confirmed_status = BookingStatus::find(2);
        $active_status = BookingStatus::find(3);
        $completed_status = BookingStatus::find(4);
        $cancelled_status = BookingStatus::find(5);

        // Recent Bookings (last 24h)
        $recent_bookings = Booking::where('company_id', $company_id)
            ->with(['vehicle','bookingStatus'])
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get();

        // Today's Pickups and Dropoffs
        $today = Carbon::today();
        $pickups_today = Booking::whereDate('pickup_date', $today)
            ->where('company_id', $company_id)
            ->where('booking_status_id', 3)
            ->count();
        $dropoffs_today = Booking::whereDate('dropoff_date', $today)
            ->where('company_id', $company_id)
            ->where('booking_status_id', 4)
            ->count();

        // Vehicles reused today
        $todayBookings = Booking::where('company_id', $company_id)
            ->where(function($query) use ($today) {
                $query->whereDate('pickup_date', $today)
                    ->orWhereDate('dropoff_date', $today);
            })
            ->with('vehicle','vehicle.vehicleModel')
            ->get();

        $reuse_same_day = [];
        foreach ($todayBookings as $booking1) {
            foreach ($todayBookings as $booking2) {
                if ($booking1->vehicle_id === $booking2->vehicle_id && $booking1->id !== $booking2->id) {
                    $dropoffDateTime = Carbon::parse($booking1->dropoff_date . ' ' . $booking1->dropoff_time);
                    $pickupDateTime = Carbon::parse($booking2->pickup_date . ' ' . $booking2->pickup_time);

                    if ($dropoffDateTime->isSameDay($today) && $pickupDateTime->isSameDay($today)) {
                        if ($dropoffDateTime->lt($pickupDateTime)) {
                            $reuse_same_day[] = [
                                'model' => $booking1->vehicle->vehicleModel->title ?? 'Unknown',
                                'plate' => $booking1->vehicle->plate ?? 'No Plate',
                                'dropoff_time' => $dropoffDateTime->format('H:i'),
                                'pickup_time' => $pickupDateTime->format('H:i'),
                                'dropoff_customer_info' => $booking1->first_name . ' ' . $booking1->last_name
                                    . ' (' . $booking1->email . ', ' . $booking1->phone . ')',
                                'pickup_customer_info' => $booking2->first_name . ' ' . $booking2->last_name
                                    . ' (' . $booking2->email . ', ' . $booking2->phone . ')',
                            ];
                        }
                    }
                }
            }
        }

        // Booking Overview
        $today_bookings = Booking::with(['vehicle','bookingStatus'])
            ->where('company_id', $company_id)
            ->whereDate('created_at', $today)
            ->get();

        $start_date = Carbon::now()->startOfMonth();
        $end_date = Carbon::now()->endOfMonth();
        $monthly_bookings = Booking::with(['vehicle','bookingStatus'])
            ->where('company_id', $company_id)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        // Bookings Over Time (yearly)
        $year = request('year', now()->year);
        $startDate = Carbon::createFromDate($year, 1, 1)->startOfDay();
        $endDate = Carbon::createFromDate($year, 12, 31)->endOfDay();

        $reservation = Booking::selectRaw("DATE_FORMAT(pickup_date, '%Y-%m') as month, booking_status_id, COUNT(*) as total")
            ->where('company_id', $company_id)
            ->whereIn('booking_status_id', [4,5])
            ->whereDate('pickup_date', '>=', $startDate)
            ->whereDate('pickup_date', '<=', $endDate)
            ->groupBy('month', 'booking_status_id')
            ->orderBy('month')
            ->get();

        $Data = [];
        foreach ($reservation as $r) {
            $month = $r->month;
            $status = $r->booking_status_id == 4 ? 'completed' : 'cancelled';
            if (!isset($Data[$month])) {
                $Data[$month] = ['completed' => 0, 'cancelled' => 0];
            }
            $Data[$month][$status] = $r->total;
        }

        if(request()->ajax()) {
            return response()->json($Data);
        }

        $profit = Booking::where('company_id', $company_id)->selectRaw('SUM(total_price - commission_amount) as profit')->value('profit');
        $revenue = Booking::where('company_id', $company_id)->selectRaw('SUM(total_price) as earn')->value('earn');
        $commissions = Booking ::where('company_id', $company_id)->selectRaw('SUM(commission_amount) as total_commissions')->value('total_commissions');


        return view('company.dashboard')->with([
            'user' => $user,
            'company_id' => $company_id,
            'all_vehicles' => $all_vehicles,
            'available_vehicles' => $available_vehicles,
            'booked_vehicles' => $booked_vehicles,
            'maintenance_vehicles' => $maintenance_vehicles,
            'inactive_vehicles' => $inactive_vehicles,
            'reserved_vehicles' => $reserved_vehicles,
            'all_bookings' => $all_bookings,
            'pending_bookings' => $pending_bookings,
            'confirmed_bookings' => $confirmed_bookings,
            'active_bookings' => $active_bookings,
            'completed_bookings' => $completed_bookings,
            'cancelled_bookings' => $cancelled_bookings,
            'recent_bookings' => $recent_bookings,
            'today_bookings' => $today_bookings,
            'monthly_bookings' => $monthly_bookings,
            'pickups_today' => $pickups_today,
            'dropoffs_today' => $dropoffs_today,
            'total_staff' => $total_staff,
            'stafflists' => $stafflists,
            'reuse_same_day' => $reuse_same_day,
            'reservation' => $reservation,
            'Data' => $Data,
            'available_status' => $available_status,
            'booked_status' => $booked_status,
            'maintenance_status' => $maintenance_status,
            'inactive_status' => $inactive_status,
            'rented_status' => $rented_status,
            'pending_status' => $pending_status,
            'confirmed_status' => $confirmed_status,
            'active_status' => $active_status,
            'completed_status' => $completed_status,
            'cancelled_status' => $cancelled_status,
            'profit' => $profit,
            'revenue' => $revenue,
            'commissions' => $commissions
        ]);
    }



    public function financialsOverview()
    {
        $payout = Booking::where('company_id',auth()->user()->company_id)->selectRaw('SUM(total_price - commission_amount) as payout')->value('payout');
        $revenue = Booking::where('company_id',auth()->user()->company_id)->selectRaw('SUM(total_price) as revenue')->value('revenue');
        $commission = Booking::where('company_id',auth()->user()->company_id)->selectRaw('SUM(commission_amount) as commission')->value('commission');

       //bookingsTrend

        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        $lastMonthDate = Carbon::now()->subMonth();

        $currentMonthBookings = DB::table('bookings')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('company_id',auth()->user()->company_id)
            ->count();


        $lastMonthBookings = DB::table('bookings')
            ->whereYear('created_at', $lastMonthDate->year)
            ->whereMonth('created_at', $lastMonthDate->month)
            ->where('company_id',auth()->user()->company_id)
            ->count();

        $percentageChange = 0;

        if ($lastMonthBookings > 0)
        {
            $percentageChange = (($currentMonthBookings - $lastMonthBookings) / $lastMonthBookings) * 100;
        }

        $status = match (true)
        {
            $percentageChange > 0 => 'increase',
            $percentageChange < 0 => 'decrease',
            default => 'no_change',
        };

        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $trend[] = DB::table('bookings')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('company_id',auth()->user()->company_id)
                ->count();
        }

        return view('company.financials')->with([
            'payout' => $payout,
            'revenue'=> $revenue,
            'commission'=> $commission,
            'trend'=> $trend,
            'status' => $status,
            'currentMonthBookings' => $currentMonthBookings,
            'lastMonthBookings' => $lastMonthBookings,
            'percentageChange' => ($percentageChange),

        ]);
    }

    public function financials(Request $request)
    {
        $period = $request->validate([
            'period'=>'nullable|in:week,month,year',
            'week_number'=>'nullable|integer|min:1|max:5',
            'month'=>'nullable|integer|min:1|max:12',
            'year'=>'nullable|integer|min:2000|max:2100',
        ]);

        switch ($period['period']) {
            case 'week':
                return $this->weeklyChart(
                    $period['week_number'] ?? null,
                    $period['month']?? null,
                    $period['year'] ?? null
                );
            case 'year':
                return $this->yearlyChart();

            default:
                return $this->monthlyChart(
                    $period['year'] ?? null,

                );
        }
    }

    private function weeklyChart($week_number, $month, $year)
    {
        $now = Carbon::now();
        $year = $year ?? $now->year;
        $month = $month ?? $now->month;

        if(!$week_number)
        {
            $week_number = ceil($now->day/7);
        }

        $startofMonth = Carbon::create($year,$month,1)->startOfMonth();

        $start = $startofMonth->copy()->addWeeks($week_number - 1)->startOfWeek(Carbon::MONDAY);
        $end = $start->copy()->endOfWeek(Carbon::SUNDAY);


        $results = DB::table('bookings')
            ->selectRaw('
            WEEKDAY(created_at) as day,
            SUM(total_price) as revenue,
            SUM(commission_amount) as commission,
            SUM(total_price - commission_amount) as payout
        ')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('day')
            ->orderBy('day')
            ->where('company_id',auth()->user()->company_id)
            ->get();

        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        $revenue = array_fill(0, 7, 0);
        $payout = array_fill(0, 7, 0);
        $commission = array_fill(0, 7, 0);

        foreach ($results as $row) {
            $index = $row->day;
            $revenue[$index] = (float) $row->revenue;
            $payout[$index] = (float) $row->payout;
            $commission[$index] = (float) $row->commission;
        }

        return response()->json([
            'categories' => $days,
            'revenue' => $revenue,
            'payout' => $payout,
            'commission' => $commission,
            'week_number'=>$week_number,
            'month'=> $month,
            'year'=> $year,
            'week_start' => $start->toDateString(),
            'week_end' => $end->toDateString(),
        ]);
    }

    private function monthlyChart($year)
    {
        $year = $year ?? Carbon::now()->year;

        $start = Carbon::create($year,1)->startOfMonth();
        $end = Carbon::create($year,12)->endOfMonth();

        $results = DB::table('bookings')
            ->selectRaw('
            MONTH(created_at) as month,
            SUM(total_price) as revenue,
            SUM(commission_amount) as commission,
            SUM(total_price - commission_amount) as payout
        ')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('month')
            ->orderBy('month')
            ->where('company_id',auth()->user()->company_id)
            ->get();

        $months = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];

        $revenue = array_fill(0, 12, 0);
        $payout = array_fill(0, 12, 0);
        $commission = array_fill(0, 12, 0);

        foreach ($results as $row) {
            $index = $row->month - 1;
            $revenue[$index] = (float) $row->revenue;
            $payout[$index] = (float) $row->payout;
            $commission[$index] = (float) $row->commission;
        }

        return response()->json([
            'categories' => $months,
            'revenue' => $revenue,
            'payout' => $payout,
            'commission' => $commission,
        ]);
    }

    private function yearlyChart()
    {
        $startYear = 2026;
        $endYear = Carbon::now()->year + 7;

        $startDate = Carbon::create($startYear)->startOfYear();
        $endDate = Carbon::create($endYear)->endOfYear();

        $all_results = DB::table('bookings')
            ->selectRaw('
            YEAR(created_at) as year,
            SUM(total_price) as revenue,
            SUM(commission_amount) as commission,
            SUM(total_price - commission_amount) as payout
        ')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year')
            ->orderBy('year')
            ->where('company_id',auth()->user()->company_id)
            ->get();

        $years = range($startYear, $endYear);

        $revenue = array_fill(0, count($years), 0);
        $payout = array_fill(0, count($years), 0);
        $commission = array_fill(0, count($years), 0);

        foreach ($all_results as $row) {
            $index = array_search($row->year, $years);
            if ($index !== false) {
                $revenue[$index] = (float) $row->revenue;
                $payout[$index] = (float) $row->payout;
                $commission[$index] = (float) $row->commission;
            }
        }

        return response()->json([
            'categories' => $years,
            'revenue' => $revenue,
            'payout' => $payout,
            'commission' => $commission,
        ]);
    }

    /**
     * Update the locale/language preference for the authenticated user.
     *
     * Validates the input locale against supported locales and updates the user record.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function updateLocale(Request $request){

        $locales = LocalesEnum::locales();


        if (!in_array($request->input('locale_val'), $locales)) {
            return redirect()->back();
        }

        try {
            $user = auth()->user();

            $user->update([
                'locale' => $request->input('locale_val'),
            ]);
            return redirect()->back();
        } catch (\Exception $exception) {
            report($exception);
            FlashNotification::error('Error!', __('returnMessages.wrong'));

            return redirect()->back();
        }}

}
