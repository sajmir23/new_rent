@extends('admin.layout.app')

@section('custom-css')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
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
                            <!--begin::Stats-->
                            <div class="d-flex align-self-center flex-center flex-shrink-0">
                                <a href="{{ route('admin.financials') }}" class="btn btn-light-success">
                                    <i class="fas fa-chart-pie me-1"></i> Financial Overview
                                </a>
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
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <div class="col-xl-4">
                    <a href="{{ route('admin.companies.index') }}" class="card bg-body hoverable mb-5">
                        <div class="card-body">
                            <i class="ki-outline ki-chart-simple text-primary fs-2x ms-n1"></i>
                            <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">Total Companies</div>
                            <div class="fw-semibold text-black-400">{{ $totalcompanies }} Company</div>
                        </div>
                    </a>

                    <a class="card bg-dark  mb-5">
                        <div class="card-body">
                            <i class="ki-outline ki-cheque text-gray-100 fs-2x ms-n1"></i>
                            <div class="text-gray-100 fw-bold fs-2 mb-2 mt-5">Total Vehicles</div>
                            <div class="fw-semibold text-gray-100">{{ $totalvehicles }} Vehicles</div>
                        </div>
                    </a>

                    <a class="card bg-warning mb-5">
                        <div class="card-body">
                            <i class="ki-outline ki-briefcase text-white fs-2x ms-n1"></i>
                            <div class="text-white fw-bold fs-2 mb-2 mt-5">Total Active Bookings</div>
                            <div class="fw-semibold text-white">{{ $active_bookings }} Active Bookings</div>
                        </div>
                    </a>

                    <a class="card bg-info hoverable mb-5">
                        <div class="card-body">
                            <i class="ki-outline ki-chart-pie-simple text-white fs-2x ms-n1"></i>
                            <div class="text-white fw-bold fs-2 mb-2 mt-5">Total Completed Bookings</div>
                            <div class="fw-semibold text-white">{{ $completed_bookings }} Completed Bookings</div>
                        </div>
                    </a>

                    <div class="card mb-5 mb-xl-8">
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bold mb-2 text-gray-900">Activities</span>
                                <span class="text-muted fw-semibold fs-7">{{ $recent_bookings->count() }} Bookings in the last 24h </span>
                            </h3>
                        </div>
                        <div class="card-body pt-5">
                            <div class="timeline-label" style="min-height:160px; max-height: 360px; overflow-y: scroll; overflow-x:hidden ">
                                @foreach($recent_bookings as $booking)
                                    <div class="timeline-item">
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">
                                            {{\Carbon\Carbon::parse($booking->created_at)->setTimezone('Europe/Tirane')->format('H:i')}}
                                        </div>
                                        <div class="timeline-badge">
                                            <i class="fa fa-genderless fs-1
                        @if($booking->bookingStatus == 'Approved') text-success
                        @elseif($booking->bookingStatus == 'Pending') text-warning
                        @else text-danger @endif"></i>
                                        </div>
                                        <div class="timeline-content fw-semibold text-gray-800 ps-3">
                                            Vehicle {{ $booking->vehicle->vehicleModel->title ?? 'Unknown Model' }} from
                                            {{ $booking->vehicle->company->name ?? 'Unknown Company' }} was booked
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col:-->
                <!--begin::Col:-->
                <div class="col-xl-8">
                    <!--begin::Engage widget-->
                    {{--<div class="card bgi-position-y-bottom bgi-position-x-end bgi-no-repeat bgi-size-cover min-h-250px bg-body mb-5 mb-xl-8"
                         style="background-position: 100% 50px;background-size: 500px auto;background-image:url('{{ asset('metronic/assets/media/misc/city.png') }}')" dir="ltr">
                        <div class="card-body d-flex flex-column justify-content-center ps-lg-12">
                            <h3 class="text-gray-900 fs-2qx fw-bold mb-7">Our companies <br />Companies</h3>
                            <div class="m-0">
                                <a href="{{ route('admin.companies.index') }}" class="btn btn-dark fw-semibold px-6 py-3">All Companies</a>
                            </div>
                        </div>
                    </div>--}}

                    <div class="card border-0 text-center py-6 px-4 mx-auto mb-10 position-relative overflow-hidden"
                         style="max-width: 900px; max-height: 700px; background: radial-gradient(circle at top right, rgba(13,202,240,0.25), transparent 60%), radial-gradient(circle at bottom left, rgba(25,135,84,0.15), transparent 60%),
                         linear-gradient(135deg, #f8fbff 0%, #eef6ff 100%); box-shadow: 0 20px 40px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.6); backdrop-filter: blur(6px); border-radius: 20px; ">

                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10"
                             style="background: linear-gradient(120deg,transparent 30%, rgba(255,255,255,0.6) 50%, transparent 70%);">
                        </div>

                        <div class="position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="badge bg-light-info text-info fw-semibold px-4 py-2">Monthly Analytics</span>
                                <div class="symbol symbol-45px symbol-circle bg-info bg-opacity-10"><span class="symbol-label"><i class="fas fa-chart-line fs-3 text-info"></i></span>
                                </div>
                            </div>
                            <div class="fs-6 fw-semibold text-gray-500 text-uppercase mb-1">
                                Bookings Trend
                            </div>
                            <div class="fs-1 fw-bolder text-gray-900 mb-2">
                                {{ $currentMonthBookings }}
                            </div>
                            <div class="fs-7 text-gray-600 mb-3">
                                Compared to last month: {{ $lastMonthBookings }}
                            </div>
                            <div class="mb-4">
                                @if($status === 'increase')
                                    <span class="badge bg-success bg-opacity-10 text-success fs-7 fw-bold px-4 py-2">
                      <i class="fas fa-arrow-up me-1"></i> {{ $percentageChange }}% Growth</span>
                                @elseif($status === 'decrease')
                                    <span class="badge bg-danger bg-opacity-10 text-danger fs-7 fw-bold px-4 py-2">
                    <i class="fas fa-arrow-down me-1"></i> {{ abs($percentageChange) }}% Drop</span>
                                @else
                                    <span class="badge bg-light text-muted fs-7 fw-bold px-4 py-2">No Change</span>
                                @endif
                            </div>

                            <div id="bookings-sparkline" class="mt-3" style="height: 30px;"></div>

                        </div>
                    </div>
                    <!--end::Engage widget-->

                    <!--begin::Tables-->
                    <div class="card mb-10 mb-xl-10">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Companies</span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                                <div class="table-responsive" style="min-height: 260px; max-height: 260px; overflow-y:auto;">
                                <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                                    <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="min-w-100px">Logo</th>
                                        <th class="min-w-150px">Company Name</th>
                                        <th class="min-w-150px">Admin Name</th>
                                        <th class="min-w-120px">Staff</th>
                                        <th class="min-w-120px">Vehicles</th>
                                        <th class="min-w-120px">Bookings</th>
                                        <th class="min-w-120px">Revenue</th>
                                        <th class="min-w-120px">Commissions</th>
                                        <th class="min-w-120px">Net Profit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($companies as $company)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-45px me-2">
                                    <span class="symbol-label">
                                        <img src="{{ asset('storage/'. $company->logo) }}" class="h-50 align-self-center" alt="Logo"/>
                                    </span></div>
                                            </td>
                                            <td>
                                                <a class="text-gray-600 fw-bold text-hover-primary mb-1 fs-6">
                                                    {{ $company->name }}
                                                </a>
                                            </td>
                                            <td class="fw-bold text-gray-600 fw-bold text-hover-primary mb-1 fs-6">
                                                {{$company->admin->first_name}} {{ $company->admin->last_name}}
                                            </td>
                                            <td class="fw-bold text-gray-600 fw-bold text-hover-primary mb-1 fs-6">
                                                {{$company-> staff_count }}
                                            </td>
                                            <td class="fw-bold text-gray-600 fw-bold text-hover-primary mb-1 fs-6">
                                               {{ $company->vehicles_count }}
                                            </td>

                                            <td class="fw-bold text-gray-600 fw-bold text-hover-primary mb-1 fs-6">
                                                {{ $company->bookings_count }}
                                            </td>
                                            <td class="fw-bold text-success text-end fs-6">
                                                €{{ number_format($company->revenue, 2) }}
                                            </td>

                                            <td class="fw-bold text-danger text-end fs-6">
                                                €{{ number_format($company->commissions, 2) }}
                                            </td>

                                            <td class="fw-bold text-warning text-end fs-6">
                                                €{{ number_format($company->profit, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end::Tables-->
                    <!--begin::Graphics-->
                    <div class="row">
                        <!-- Bookings Graph -->
                        <div class="col-md-6">
                            <div class="card card-flush">
                                <div class="card-header pt-5">
                                    <h3 class="card-title">Booking Status</h3>
                                </div>
                                <div class="card-body">
                                    <div id="bookings_pie_chart" style="height: 350px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Vehicle Status Graph -->
                        <div class="col-md-6">
                            <div class="card card-flush">
                                <div class="card-header pt-5">
                                    <h3 class="card-title">Vehicle Status</h3>
                                </div>
                                <div class="card-body">
                                    <div id="vehicles_status_pie_chart" style="height: 350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Graphics-->
                </div>
                <!--end::Col:-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content-->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.2.0/countUp.min.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('metronic/assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('metronic/assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('metronic/assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('metronic/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('metronic/assets/js/custom/utilities/modals/new-target.js') }}"></script>
<script src="{{ asset('metronic/assets/js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ asset('metronic/assets/js/custom/utilities/modals/users-search.js') }}"></script>
<!--end::Custom Javascript-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var bookingsCounts = {
            active: {{ $active_bookings }},
            completed: {{ $completed_bookings }},
            cancelled: {{ $cancelled_bookings }},
            pending: {{ $pending_bookings }},
            confirmed: {{ $confirmed_bookings }}
        };

        var options = {
            series: [
                {{$active_percentage}},
                {{$completed_percentage}},
                {{$cancelled_percentage}},
                {{$pending_percentage}},
                {{$confirmed_percentage}}
            ],
            chart: {
                type: 'pie',
                height: 350
            },
            labels: ['Active', 'Completed', 'Cancelled','Pending','Confirmed'],
            colors: ['#00C851', '#007bff', '#ff4444','#ffbb33', '#33b5e5'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    let label = opts.w.globals.labels[opts.seriesIndex];
                    let value = Object.values(bookingsCounts)[opts.seriesIndex];
                    return label + ": " + value + " (" + val.toFixed(1) + "%)";
                }
            },
            tooltip: {
                y: {
                    formatter: function (val, opts) {
                        let value = Object.values(bookingsCounts)[opts.seriesIndex];
                        return value + " bookings (" + val.toFixed(1) + "%)";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#bookings_pie_chart"), options);
        chart.render();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var bookingsCounts = {
            available: {{ $available_vehicles }},
            booked: {{ $booked_vehicles }},
            maintenance: {{ $maintenance_vehicles }},
            inactive: {{ $inactive_vehicles }},
            reserved: {{ $reserved_vehicles }}
        };

        var options = {
            series: [
                {{$available_percentage}},
                {{$booked_percentage}},
                {{$maintenance_percentage}},
                {{$inactive_percentage}},
                {{ $reserved_percentage}}
            ],
            chart: {
                type: 'pie',
                height: 350
            },
            labels: ['Available','Booked', 'Maintenance','Inactive','Reserved'],
            colors: ['#00C851', '#007bff', '#ff4444','#ffbb33', '#33b5e5'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    let label = opts.w.globals.labels[opts.seriesIndex];
                    let value = Object.values(bookingsCounts)[opts.seriesIndex];
                    return label + ": " + value + " (" + val.toFixed(1) + "%)";
                }
            },
            tooltip: {
                y: {
                    formatter: function (val, opts) {
                        let value = Object.values(bookingsCounts)[opts.seriesIndex];
                        return value + " bookings (" + val.toFixed(1) + "%)";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#vehicles_status_pie_chart"), options);
        chart.render();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const options = {
            chart: {
                type: 'area',
                height: 50,
                sparkline: { enabled: true },
            },
            stroke: { curve: 'smooth', width: 2 },
            fill: { opacity: 0.3 },
            series: [{
                name: 'Bookings',
                data: @json($trend)
            }],
            colors: ['#17C653']
        };

        const chart = new ApexCharts(document.querySelector("#bookings-sparkline"), options);
        chart.render();
    });
</script>

@endsection