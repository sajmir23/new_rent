<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LocalesEnum;
use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
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
     * Display the admin dashboard with statistics and recent data.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $user = Auth::user();

        //Card : Total Companies and Table : Companies

        $totalcompanies = Company::count();


        $companies = Company::with('admin')
            ->withSum('bookings as revenue', 'total_price')
            ->withSum('bookings as commissions', 'commission_amount')
            ->withSum('bookings as profit', DB::raw('total_price - commission_amount'))
            ->withCount(['staff', 'vehicles', 'bookings'])
            ->orderByDesc('revenue')
            ->get();


        $staff = User::where('user_type', UserTypesEnum::STAFF);
        $admin = User::where('user_type', UserTypesEnum::COMPANY_ADMIN);

         //Cards : Active Bookings and Completed Bookings
        $bookingCounts = Booking::select('booking_status_id', DB::raw('count(*) as total'))
            ->groupBy('booking_status_id')
            ->pluck('total','booking_status_id');

        $active_bookings    = $bookingCounts[3] ?? 0;
        $completed_bookings = $bookingCounts[4] ?? 0;
        $cancelled_bookings = $bookingCounts[5] ?? 0;
        $pending_bookings   = $bookingCounts[1] ?? 0;
        $confirmed_bookings = $bookingCounts[2] ?? 0;

        $total_bookings = array_sum([
            $active_bookings,
            $completed_bookings,
            $cancelled_bookings,
            $pending_bookings,
            $confirmed_bookings
        ]);

        $active_percentage    = $total_bookings ? round(($active_bookings / $total_bookings) * 100, 2) : 0;
        $completed_percentage = $total_bookings ? round(($completed_bookings / $total_bookings) * 100, 2) : 0;
        $cancelled_percentage = $total_bookings ? round(($cancelled_bookings / $total_bookings) * 100, 2) : 0;
        $pending_percentage   = $total_bookings ? round(($pending_bookings / $total_bookings) * 100, 2) : 0;
        $confirmed_percentage = $total_bookings ? round(($confirmed_bookings / $total_bookings) * 100, 2) : 0;

        // Vehicles grouped by status
        $vehicleCounts = Vehicle::select('vehicle_status_id', DB::raw('count(*) as total'))
            ->groupBy('vehicle_status_id')
            ->pluck('total','vehicle_status_id');

        $totalvehicles = array_sum($vehicleCounts->toArray()); // total vehicles

        $available_vehicles   = $vehicleCounts[1] ?? 0;
        $booked_vehicles      = $vehicleCounts[2] ?? 0;
        $maintenance_vehicles = $vehicleCounts[3] ?? 0;
        $inactive_vehicles    = $vehicleCounts[4] ?? 0;
        $reserved_vehicles    = $vehicleCounts[5] ?? 0;

        $available_percentage   = $totalvehicles ? round(($available_vehicles / $totalvehicles) * 100, 2) : 0;
        $booked_percentage      = $totalvehicles ? round(($booked_vehicles / $totalvehicles) * 100, 2) : 0;
        $maintenance_percentage = $totalvehicles ? round(($maintenance_vehicles / $totalvehicles) * 100, 2) : 0;
        $inactive_percentage    = $totalvehicles ? round(($inactive_vehicles / $totalvehicles) * 100, 2) : 0;
        $reserved_percentage    = $totalvehicles ? round(($reserved_vehicles / $totalvehicles) * 100, 2) : 0;

        // Recent bookings (limited for performance)
        $recent_bookings = Booking::with('company','vehicle')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->limit(20)
            ->get();


        //bookingsTrend

        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        $lastMonthDate = Carbon::now()->subMonth();

        $currentMonthBookings = DB::table('bookings')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();


        $lastMonthBookings = DB::table('bookings')
            ->whereYear('created_at', $lastMonthDate->year)
            ->whereMonth('created_at', $lastMonthDate->month)
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
                ->count();
        }



        return view('admin.dashboard', [
            'totalcompanies' => $totalcompanies,
            'user' => $user,
            'totalvehicles' => $totalvehicles,
            'active_bookings' => $active_bookings,
            'completed_bookings' => $completed_bookings,
            'cancelled_bookings' => $cancelled_bookings,
            'pending_bookings' => $pending_bookings,
            'confirmed_bookings' => $confirmed_bookings,
            'companies' => $companies,
            'staff' => $staff,
            'admin' => $admin,
            'active_percentage' => $active_percentage,
            'completed_percentage' => $completed_percentage,
            'cancelled_percentage' => $cancelled_percentage,
            'pending_percentage' => $pending_percentage,
            'confirmed_percentage' => $confirmed_percentage,
            'available_percentage' => $available_percentage,
            'booked_percentage' => $booked_percentage,
            'maintenance_percentage' => $maintenance_percentage,
            'inactive_percentage' => $inactive_percentage,
            'reserved_percentage' => $reserved_percentage,
            'recent_bookings' => $recent_bookings,
            'available_vehicles' => $available_vehicles,
            'booked_vehicles' => $booked_vehicles,
            'maintenance_vehicles' => $maintenance_vehicles,
            'inactive_vehicles' => $inactive_vehicles,
            'reserved_vehicles' => $reserved_vehicles,
            'currentMonthBookings' => $currentMonthBookings,
            'lastMonthBookings'    => $lastMonthBookings,
            'percentageChange'     => round($percentageChange, 2),
            'status'               => $status,
            'trend'                => $trend,

        ]);
    }

    public function financialsOverview()
    {
        $payout = Booking::selectRaw('SUM(total_price - commission_amount) as payout')->value('payout');
        $revenue = Booking::selectRaw('SUM(total_price) as revenue')->value('revenue');
        $commission = Booking::selectRaw('SUM(commission_amount) as commission')->value('commission');

       $companiesCount = Company::whereMonth('created_at',now()->month)
           ->whereYear('created_at',now()->year)
           ->count();

        return view('admin.financials')->with([
            'payout'               => $payout,
            'revenue'              => $revenue,
            'commission'           => $commission,
            'companiesCount'       => $companiesCount,
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
     * Update the user's preferred locale.
     *
     * @param Request $request
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
