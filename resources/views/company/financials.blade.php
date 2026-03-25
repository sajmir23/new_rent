@extends('company.layout.app')

@section('custom-css')
    <link href="{{ asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar py-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="d-flex align-items-center pt-1">
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{ route('company.dashboard') }}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-white-700 fs-6"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><i class="ki-outline ki-right fs-7 text-white-700 mx-n1"></i></li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Dashboard</li>
                    </ul>
                </div>

                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">FINANCIAL OVERVIEW</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-8 mt-n6 justify-content-center">
            <div class="card shadow-sm border text-center py-4 bg-primary text-white mx-2" style="max-width: 350px;">
                <div class="mb-2">
                    <i class="fas fa-coins fa-2x text-white"></i>
                </div>
                <span class="fs-5 fw-semibold">Payout</span>
                <div class="fs-2 fw-bold mt-2 d-flex justify-content-center align-items-center">€
                    <span data-kt-countup="true" data-kt-countup-value="{{$payout}}" data-kt-countup-decimal-places="2">{{ number_format($payout, 2, '.', '') }}</span>
                </div>
            </div>

            <div class="card shadow-sm border text-center py-4 bg-success-active text-white mx-2" style="max-width: 350px;">
                <div class="mb-2">
                    <i class="fas fa-chart-line fa-2x text-white"></i>
                </div>
                <span class="fs-5 fw-semibold">Revenue</span>
                <div class="fs-2 fw-bold mt-2 d-flex justify-content-center align-items-center">€
                    <span data-kt-countup="true" data-kt-countup-value="{{$revenue}}" data-kt-countup-decimal-places="2">{{number_format($revenue, 2, '.', '')}}</span>
                </div>
            </div>

            <div class="card shadow-sm border text-center py-4 bg-warning text-white mx-2" style="max-width: 350px;">
                <div class="mb-2">
                    <i class="fas fa-hand-holding-usd fa-2x text-white"></i>
                </div>
                <span class="fs-5 fw-semibold">Commissions</span>
                <div class="fs-2 fw-bold mt-2 d-flex justify-content-center align-items-center">€
                    <span data-kt-countup="true" data-kt-countup-value="{{$commission}}" data-kt-countup-decimal-places="2">{{number_format($commission, 2, '.', '')}}</span>
                </div>
            </div>
        </div>

        <div class="row mb-10">
            <div class="col-xl-8 col-lg-7 col-md-12 mb-6">
                <div class="card card-xl-stretch h-100">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">Overview</span>
                        </h3>
                        <div class="card-toolbar d-flex align-items-center gap-3">
                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" data-period="week">Week</a>
                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" data-period="month">Month</a>
                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4" data-period="year">Year</a>

                            <div id="dropdowns" class="d-flex align-items-center gap-2">
                                <select id="select-year" class="form-select form-select-sm">
                                    @for($y = 2026; $y <= now()->year + 7; $y++)
                                        <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>

                                <select id="select-month" class="form-select form-select-sm">
                                    @foreach(range(1,12) as $m)
                                        <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>

                                <select id="select-week" class="form-select form-select-sm">
                                    @for($w=1; $w<=5; $w++)
                                        <option value="{{ $w }}">Week {{ $w }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="kt_charts_widget_7_chart" style="height: 300px;"></div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5 col-md-12 mb-6">
                <div class="card border-0 h-100 py-6 px-4 position-relative overflow-hidden"
                     style="background: radial-gradient(circle at top right, rgba(13,202,240,0.25), transparent 60%),
                            radial-gradient(circle at bottom left, rgba(25,135,84,0.15), transparent 60%),
                            linear-gradient(135deg, #f8fbff 0%, #eef6ff 100%);
                            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
                            border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="badge bg-light-info text-info fw-semibold px-4 py-2">Monthly Analytics</span>
                        <div class="symbol symbol-45px symbol-circle bg-info bg-opacity-10">
                            <span class="symbol-label"><i class="fas fa-chart-line fs-3 text-info"></i></span>
                        </div>
                    </div>

                    <div class="fs-6 fw-semibold text-gray-500 text-uppercase mb-1">Bookings Trend</div>
                    <div class="fs-1 fw-bolder text-gray-900 mb-2">{{ $currentMonthBookings }}</div>
                    <div class="fs-7 text-gray-600 mb-3">Compared to last month: {{ $lastMonthBookings }}</div>

                    <div class="mb-4">
                        @if($status === 'increase')
                            <span class="badge bg-success bg-opacity-10 text-success fs-7 fw-bold px-4 py-2">
                                <i class="fas fa-arrow-up me-1"></i> {{ $percentageChange }}% Growth
                            </span>
                        @elseif($status === 'decrease')
                            <span class="badge bg-danger bg-opacity-10 text-danger fs-7 fw-bold px-4 py-2">
                                <i class="fas fa-arrow-down me-1"></i> {{ round(abs($percentageChange),2) }}% Drop
                            </span>
                        @else
                            <span class="badge bg-light text-muted fs-7 fw-bold px-4 py-2">No Change</span>
                        @endif
                    </div>

                    <div id="bookings-sparkline" style="height: 30px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        const chartElement = document.querySelector('#kt_charts_widget_7_chart');

        const chartOptions = {
            series: [
                { name: 'Commissions', data: [] },
                { name: 'Payout', data: [] },
                { name: 'Revenue', data: [] },
            ],
            chart: { type: 'area', height: 350, stacked: true, toolbar: { show: false } },
            colors: ['#F6C000', '#1B84FF','#17C653'],
            stroke: { curve: 'smooth', width: 2 },
            fill: { type: 'solid', opacity: 1 },
            dataLabels: { enabled: false },
            markers: { size: 0 },
            grid: { show: false },
            xaxis: { categories: [], labels: { rotate: -45 }, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { labels: { formatter: val => `€${Math.round(val)}` } },
            tooltip: { shared: true, intersect: false, y: { formatter: val => `€${parseFloat(val).toFixed(2)}` } },
            legend: { show: true, position: 'top' }
        };

        const chart = new ApexCharts(chartElement, chartOptions);
        chart.render();

        function loadChartData(period) {
            const year = document.getElementById('select-year').value;
            const month = document.getElementById('select-month').value;
            const week = document.getElementById('select-week').value;

            let url = `/company/dashboard/financials/chart?period=${period}&year=${year}`;

            if(period === 'week') {
                url += `&month=${month}&week_number=${week}`;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    chart.updateOptions({ xaxis: { categories: data.categories } });
                    chart.updateSeries([
                        { name: 'Commissions', data: data.commission },
                        { name: 'Payout', data: data.payout },
                        { name: 'Revenue', data: data.revenue },
                    ]);
                })
                .catch(console.error);
        }

        function updateDropdownVisibility(period) {
            const yearSel = document.getElementById('select-year');
            const monthSel = document.getElementById('select-month');
            const weekSel = document.getElementById('select-week');

            yearSel.parentElement.style.display = 'inline-flex';
            monthSel.parentElement.style.display = (period === 'week') ? 'inline-flex' : 'none';
            weekSel.parentElement.style.display = (period === 'week') ? 'inline-flex' : 'none';
        }

        document.querySelectorAll('.card-toolbar a[data-period]').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('.card-toolbar a[data-period]').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const period = this.dataset.period;
                updateDropdownVisibility(period);
                loadChartData(period);
            });
        });

        ['select-year', 'select-month', 'select-week'].forEach(id => {
            document.getElementById(id).addEventListener('change', function () {
                const activePeriod = document.querySelector('.card-toolbar a.active').dataset.period;
                loadChartData(activePeriod);
            });
        });

        const defaultPeriod = document.querySelector('.card-toolbar a.active').dataset.period;
        updateDropdownVisibility(defaultPeriod);
        loadChartData(defaultPeriod);
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
                series: [{ name: 'Bookings', data: @json($trend) }],
                colors: ['#17C653']
            };

            const chart = new ApexCharts(document.querySelector("#bookings-sparkline"), options);
            chart.render();
        });
    </script>
@endsection

