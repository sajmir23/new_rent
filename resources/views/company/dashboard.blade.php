@extends('company.layout.app')

@section('custom-css')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--end::Vendor Stylesheets-->
@endsection

@section('toolbar')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
            <!--begin::Toolbar container-->
            <div class="d-flex flex-column flex-row-fluid">
                <!--begin::Toolbar wrapper-->
                <div class="d-flex align-items-center pt-1">
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="index.html" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-gray-700 fs-6"></i>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-white fw-bold lh-1">Dashboard</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Toolbar wrapper=-->
                <!--begin::Toolbar wrapper=-->
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <!--begin::Page title-->
                    <div class="page-title me-5">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Welcome Back, {{ucfirst(\Illuminate\Support\Facades\Auth::user()->first_name)}}
                            <!--begin::Description-->
                            <span class="page-desc text-gray-600 fw-semibold fs-6 pt-3">Company Description</span>
                            <!--end::Description--></h1>

                        <!--end::Title-->
                    </div>

                    <!--end::Page title-->
                    <div class="d-flex">
                        <div class="me-3">
                            <span class="badge bg-light text-dark p-2">
                                <i class="ki ki-outline ki-calendar-2 me-3"></i>
                                {{ now()->format('l, F j, Y') }}
                            </span>
                        </div>

                        <div class="d-flex align-self-center flex-center flex-shrink-0">
                            <a href="{{ route('company.financials') }}" class="btn btn-light-success">
                                <i class="fas fa-chart-pie me-1"></i> Financial Overview
                            </a>
                        </div>
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Toolbar wrapper=-->
            </div>
            <!--end::Toolbar container=-->
        </div>

        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
@endsection

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center py-4">
            <h1 class="h2 ">Company Dashboard</h1>
        </div>
        <div class="row ">
            <div class="col-xl-5 d-flex flex-column gap-4 ">
                <div class="row g-4 ">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm flex-grow-1">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted fw-semibold mb-1">Total Bookings</p>
                                    <h2 class="fw-bold mb-0">{{ $all_bookings }}</h2>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-4 rounded">
                                    <a href="{{route('company.bookings.index')}}" class="fas fa-clipboard-list text-primary fs-3" ></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm flex-grow-1">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted fw-semibold mb-1">Total Vehicles</p>
                                    <h2 class="fw-bold mb-0">{{ $all_vehicles }}</h2>
                                </div>
                                <div class="bg-success bg-opacity-10 p-4 rounded">
                                    <a href="{{route('company.vehicles.index')}}" class="fas fa-car text-success fs-3"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm text-white" style="background-color: lightgreen;">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-success fw-semibold mb-1">Today's Pickups</p>
                                    <h4 class="fw-bold mb-0">{{ $pickups_today }}</h4>
                                </div>
                                <div class="bg-white bg-opacity-25 p-3 rounded">
                                    <i class="fas fa-arrow-up text-white fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card  border-0 shadow-sm text-white" style="background-color:lightsteelblue; ">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-primary fw-semibold mb-1">Today's Dropoffs</p>
                                    <h4 class="fw-bold mb-0">{{ $dropoffs_today }}</h4>
                                </div>
                                <div class="bg-white bg-opacity-25 p-3 rounded">
                                    <i class="fas fa-arrow-down text-white fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm  ">
                            <div class="card-header bg-white pt-4">
                                <h5 class="card-title mb-2">Recent Activities</h5>
                                <p class="text-muted small">{{ $recent_bookings->count() }} bookings in the last 24h</p>
                            </div>
                            <div class="card-body pt-10">
                                <div class="timeline-container" style="height: 480px; overflow-y: auto; position: relative;">
                                    @foreach($recent_bookings as $booking)
                                        <a href="{{ route('company.bookings.show', $booking->id) }}" class="text-decoration-none text-reset">
                                            <div class="timeline-label">
                                                <div class="timeline-item">

                                                    <div class="timeline-label fw-bold text-gray-800 fs-6">
                                                        {{ \Carbon\Carbon::parse($booking->created_at)->setTimezone('Europe/Tirane')->format('H:i') }}
                                                    </div>

                                                    <div class="timeline-badge">
                                                        <i class="fa fa-genderless fs-1
                        @if($booking->bookingStatus->name == 'Approved') text-success
                        @elseif($booking->bookingStatus->name == 'Pending') text-warning
                        @else text-danger @endif">
                                                        </i>
                                                    </div>

                                                    <div class="timeline-content fw-semibold text-gray-800 ps-3">
                                                        Vehicle: {{ $booking->vehicle->vehicleModel->title ?? 'Unknown Model' }}
                                                        ({{ $booking->vehicle->plate }}) was booked
                                                        ({{ $booking->pickup_date }} - {{ $booking->dropoff_date }}).
                                                    </div>

                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-7  d-flex flex-column gap-5">
                <div style="height: 45vh; overflow-y: scroll" class="card border-0  shadow-sm ">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                        <div>
                            <h5 class="card-title mb-1">Booking Overview</h5>
                            <p class="text-muted small">{{ $all_bookings }} total bookings</p>
                        </div>
                        <ul class="nav nav-pills nav-pills-sm" id="bookingTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="today-tab" data-bs-toggle="pill" data-bs-target="#today" type="button" role="tab">Today</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="month-tab" data-bs-toggle="pill" data-bs-target="#month" type="button" role="tab">Month</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="bookingTabsContent">
                            <div class="tab-pane fade show active" id="today" role="tabpanel">
                                <div class="table-responsive" style="max-height: 250px;">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                        <tr class="text-muted">
                                            <th>ID</th>
                                            <th>Code</th>
                                            <th>Vehicle</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($today_bookings as $index => $booking)
                                            <tr>
                                                <td class="text-muted">{{ $index + 1 }}</td>
                                                <td class="text-muted">#{{$booking->booking_code}}</td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">{{ $booking->vehicle->vehicleModel->title ?? 'Unknown' }}</span>

                                                        <small class="text-muted">{{ $booking->vehicle->plate ?? 'No Plate' }}</small>

                                                    </div>
                                                </td>
                                                <td>
                                            <span class="badge
                                                @switch(strtolower($booking->bookingStatus->title_en ?? ''))
                                                    @case('pending') bg-info @break
                                                    @case('confirmed') bg-primary @break
                                                    @case('active') bg-warning @break
                                                    @case('completed') bg-success @break
                                                    @case('cancelled') bg-danger @break
                                                    @default bg-secondary
                                                @endswitch
                                           ">
                                                {{ $booking->bookingStatus->title_en ?? 'Unknown' }}
                                            </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">No bookings today.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="month" role="tabpanel">
                                <div class="table-responsive" style="max-height: 250px;">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                        <tr class="text-muted">
                                            <th>ID</th>
                                            <th>Code</th>
                                            <th>Vehicle</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($monthly_bookings as $index => $booking)
                                            <tr>
                                                <td class="text-muted">{{ $index + 1 }}</td>
                                                <td class="text-muted">#{{$booking->booking_code}}</td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">{{ $booking->vehicle->vehicleModel->title ?? 'Unknown' }}</span>

                                                        <small class="text-muted">{{ $booking->vehicle->plate ?? 'No Plate' }}</small>

                                                    </div>
                                                </td>
                                                <td>
                                            <span class="badge
                                                @switch(strtolower($booking->bookingStatus->title_en ?? ''))
                                                    @case('pending') bg-info @break
                                                    @case('confirmed') bg-primary @break
                                                    @case('active') bg-warning @break
                                                    @case('completed') bg-success @break
                                                    @case('cancelled') bg-danger @break
                                                    @default bg-secondary
                                                @endswitch
                                            ">
                                                {{ $booking->bookingStatus->title_en ?? 'Unknown' }}
                                            </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">No bookings this month.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mt-0">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                                <h5 class="card-title mb-0">Vehicles Status</h5>
                                <a href="{{route('company.vehicles.index')}}" class="btn btn-sm btn-outline-secondary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-4">
                                    <div class="position-relative" style="width: 150px; height: 150px;">
                                        <canvas id="vehicleStatusChart" width="150" height="150"></canvas>
                                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                                            <span class="fw-bold fs-4">{{ $all_vehicles }}</span>
                                            <span class="d-block text-muted small">Total</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="vehicle-status-list">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge  me-2" style="background: {{$available_status->text_color}} ">&nbsp;</span>
                                            <span>Available</span>
                                        </div>
                                        <span class="fw-bold">{{ $available_vehicles }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge  me-2" style="background: {{$booked_status->text_color}}">&nbsp;</span>
                                            <span>Booked</span>
                                        </div>
                                        <span class="fw-bold">{{ $booked_vehicles }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge  me-2" style="background:  {{$maintenance_status->text_color}}">&nbsp;</span>
                                            <span>Maintenance</span>
                                        </div>
                                        <span class="fw-bold">{{ $maintenance_vehicles }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge me-2" style="background:  {{$inactive_status->text_color}}">&nbsp;</span>
                                            <span>Inactive</span>
                                        </div>
                                        <span class="fw-bold">{{ $inactive_vehicles }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge  me-2" style="background:  {{$rented_status->text_color}}">&nbsp;</span>
                                            <span>Rented</span>
                                        </div>
                                        <span class="fw-bold">{{ $reserved_vehicles }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                                <h5 class="card-title mb-0">Bookings Status</h5>
                                <a href="{{route('company.bookings.index')}}" class="btn btn-sm btn-outline-secondary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-4">
                                    <div class="position-relative" style="width: 150px; height: 150px;">
                                        <canvas id="bookingStatusChart" width="150" height="150"></canvas>
                                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                                            <span class="fw-bold fs-4">{{ $all_bookings }}</span>
                                            <span class="d-block text-muted small">Total</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-status-list">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="text badge me-2" style="background:{{$pending_status->text_color}} ">&nbsp;</span>
                                            <span>Pending</span>
                                        </div>
                                        <span class="fw-bold">{{ $pending_bookings }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2" style="background: {{$confirmed_status->text_color}}">&nbsp;</span>
                                            <span>Confirmed</span>
                                        </div>
                                        <span class="fw-bold">{{ $confirmed_bookings }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2" style="background:{{$active_status->text_color}}">&nbsp;</span>
                                            <span>Active</span>
                                        </div>
                                        <span class="fw-bold">{{ $active_bookings }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-dark me-2" style="background:{{$completed_status->text_color}} " >&nbsp;</span>
                                            <span>Completed</span>
                                        </div> <span class="fw-bold">{{ $completed_bookings }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-danger me-2" style="background: {{$cancelled_status->text_color}}">&nbsp;</span>
                                            <span>Cancelled</span>
                                        </div>
                                        <span class="fw-bold">{{ $cancelled_bookings}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Third Row: Staff & Reused Vehicles -->
            <div class="row gx-1 mt-4">
                <!-- Staff List Card -->
                <div class="col-xl-6 pe-2">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                            <h5 class="card-title mb-0">Company Staff</h5>
                            <span class="badge bg-primary">{{$total_staff}} Total Staff</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-height: 300px;">
                                <table class="table table-hover align-middle">
                                    <thead>
                                    <tr class="text-muted">
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($stafflists as $staff)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                            <i class="fas fa-user text-muted"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <span class="fw-semibold d-block">{{ $staff->first_name }} {{ $staff->last_name }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $staff->phone_number }}</td>
                                            <td>{{ $staff->email }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3">No staff found.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-3">
                                <a href="{{route('company.staff.index')}}" class="btn btn-sm btn-outline-primary">View All Staff</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Reused Vehicles Card -->
                <div class="col-xl-6 ps-2">
                    <div class="card  border-0 shadow-sm h-100" >
                        <div class="card-header bg-white border-0 pt-4">
                            <h5 class="card-title mb-1">Vehicles Reused Today</h5>
                            <p class="text-muted small">Dropoff & pickup by different customers today</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-height: 300px;">
                                <table class="table align-middle">
                                    <thead>
                                    <tr class="text-muted">
                                        <th>Vehicle</th>
                                        <th>Dropoff Time</th>
                                        <th>Pickup Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($reuse_same_day))
                                        @foreach($reuse_same_day as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">{{ $item['model'] }}</span>
                                                        <small class="text-muted">{{ $item['plate'] }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                            <span data-bs-toggle="tooltip" title="{{ $item['dropoff_customer_info'] }}">
                                                {{ $item['dropoff_time'] }}
                                            </span>
                                                </td>
                                                <td>
                                            <span data-bs-toggle="tooltip" title="{{ $item['pickup_customer_info'] }}">
                                                {{ $item['pickup_time'] }}
                                            </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                No vehicles are being reused today.
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                    <h5 class="card-title mb-0">Bookings Over Time</h5>
                    <div class="d-flex">
                        <select id="yearSelect" class="form-select form-select-sm">
                            @foreach ([2026, 2027, 2028, 2029, 2030] as $y)
                                <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div id="bookingsOverTimeChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    {{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>--}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{--  <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1"></script>--}}




    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('metronic/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/custom/utilities/modals/new-target.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    {{--<script src="{{ asset('assets/plugins/custom/apexcharts/apexcharts.min.js') }}"></script>--}}


    <!--end::Custom Javascript-->

    @php
        $chartData = [
            $available_vehicles,
            $booked_vehicles,
            $maintenance_vehicles,
            $inactive_vehicles,
            $reserved_vehicles
        ];

        $bookingChartData = [
            $pending_bookings,
            $confirmed_bookings,
            $active_bookings,
            $completed_bookings,
            $cancelled_bookings
        ];
    @endphp

    <!--Vehicles Status anf Bookings Status-->
    <script>
        const vehicleData = @json($chartData);
        const bookingData = @json($bookingChartData);


        const vehicleCtx = document.getElementById('vehicleStatusChart').getContext('2d');
        new Chart(vehicleCtx, {
            type: 'doughnut',
            data: {
                labels: ['Available', 'Booked', 'Maintenance', 'Inactive', 'Rented'],
                datasets: [{
                    data: vehicleData,
                    backgroundColor: [
                        '#198754',
                        '#0D6EFD',
                        '#B02A37',
                        '#6C757D',
                        '#0D6EFD'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });


        const bookingCtx = document.getElementById('bookingStatusChart').getContext('2d');
        new Chart(bookingCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Active', 'Cancelled', 'Completed'],
                datasets: [{
                    data: bookingData,
                    backgroundColor: [
                        '#FFC107',
                        '#28A745',
                        '#17A2B8',
                        '#DC3545',
                        '#212529'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    </script>

    <!--Bookings Over Time-->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chartElement = document.getElementById("bookingsOverTimeChart");
            const chartHeight = parseInt(window.getComputedStyle(chartElement).height);

            const options = {
                series: [
                    { name: "Cancelled", data: [] },
                    { name: "Completed", data: [] }
                ],
                chart:
                    { type: "area", height: chartHeight,
                        toolbar:
                        {
                            show : true,
                            tools:
                            {
                                download: false,
                                selection: false,
                                zoom: false,
                                zoomin: true,
                                zoomout: true,
                                pan: false,
                                reset: true
                            }
                        }
                    },
                dataLabels: { enabled: false },
                stroke: { curve: "smooth", width: 3 },
                xaxis: { categories: [] },
                grid: { borderColor: "#E4E6EF", strokeDashArray: 4, yaxis: { lines: { show: true } } },
                noData: {
                    text: 'Loading...',
                    align: 'center',
                    verticalAlign: 'middle',
                    style: {
                        fontSize: '16px',
                        color: '#999'
                    }
                }
            };

            const chart = new ApexCharts(chartElement, options);
            chart.render();

            function loadChartData(year) {
                chart.updateOptions({
                    series: [],
                    xaxis: { categories: [] },
                    noData: { text: 'Loading...' }
                });

                $.ajax({
                    url: window.location.pathname,
                    type: "GET",
                    data: { year: year },
                    dataType: "json",
                    success: function (rawData) {
                        const months = [];
                        const completedData = [];
                        const cancelledData = [];

                        for (const month in rawData) {
                            months.push(month);
                            completedData.push(rawData[month].completed || 0);
                            cancelledData.push(rawData[month].cancelled || 0);
                        }

                        chart.updateOptions({
                            xaxis: {
                                categories: months,
                                labels: {
                                    rotate: -45,
                                    trim: false,
                                    style: { fontSize: '12px' }
                                },
                                tickAmount: months.length,
                            },
                            noData: { text: '' }
                        });

                        chart.updateSeries([
                            { name: "Cancelled", data: cancelledData },
                            { name: "Completed", data: completedData }
                        ]);
                    },
                    error: function() {
                        chart.updateOptions({
                            noData: {
                                text: 'Error loading data',
                                style: { color: 'red' }
                            }
                        });
                    }
                });
            }
            loadChartData(new Date().getFullYear());
            const yearSelector = document.getElementById("yearSelect");
            if (yearSelector) {
                yearSelector.addEventListener("change", function () {
                    loadChartData(this.value);
                });
            }
        });
    </script>

    <!--Vehicles Reused Today - Hover -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('[data-control="select2"]').select2({
                theme: 'bootstrap-5',
                minimumResultsForSearch: Infinity,
                width: '100%'
            });
        });
    </script>

@endsection