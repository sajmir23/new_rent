@extends('company.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/resource-timegrid@6.1.9/index.global.min.css" rel="stylesheet">

@endsection

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar py-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="d-flex align-items-center pt-1">
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{route('company.dashboard')}}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-white fs-6"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{route('company.bookings.index')}}" class="text-white text-hover-primary">Bookings List</a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Booking Calendar
                        </li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Booking Calendar</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="app-container container-xxl">
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Layout-->
                    <div class="d-flex flex-column">
                        <!--begin::Content-->
                        <div class="flex-row-fluid">
                            <div class="row">
                                <div class="col-md-9">
                                    <!--begin::Card-->
                                    <div class="card">
                                        <!--begin::Card body-->
                                        <div class="card-body p-12">
                                            <div id="calendar"></div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <div class="col-md-3">
                                    <!--begin::Card-->
                                    <div class="card">
                                        <!--begin::Card body-->
                                        <div class="card-body p-12">
                                            <div id="calendar-data">
                                                <h5 class="mb-3">Booking Details</h5>
                                                <p><strong>Vehicle:</strong> <span id="detail-vehicle"></span></p>
                                                <p><strong>Status:</strong> <span id="detail-status"></span></p>
                                                <p><strong>Start:</strong> <span id="detail-start"></span></p>
                                                <p><strong>End:</strong> <span id="detail-end"></span></p>
                                                <p><strong>Customer:</strong> <span id="detail-customer"></span></p>
                                                <p><strong>Email:</strong> <span id="detail-email"></span></p>
                                                <p><strong>Phone Number:</strong> <span id="detail-phone"></span></p>
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                            </div>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Layout-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
        </div>
        <!--end::Main-->
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dayMaxEventRows: 3,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },

                events: '{{ route('company.bookings.calendar_data') }}',
                eventClick: function(info) {
                    let event = info.event;
                    let props = event.extendedProps;

                    // Update each field
                    document.getElementById('detail-vehicle').innerText   = event.title;
                    document.getElementById('detail-status').innerHTML = `
                        <span class="badge"
                            style="
                                color:${props.status_color};
                                background-color:${props.status_bg};
                                padding:0.25em 0.5em;
                                border-radius:0.25rem;
                                font-weight:600;
                                display:inline-block;
                            ">
                            ${props.status}
                        </span>
                    `;
                    document.getElementById('detail-start').innerText     = props.pickup_time;
                    document.getElementById('detail-end').innerText       = props.dropoff_time;
                    document.getElementById('detail-customer').innerText  = props.first_name + ' ' + props.last_name;
                    document.getElementById('detail-email').innerText     = props.email;
                    document.getElementById('detail-phone').innerText     = props.phone ?? '';
                }
            });
            calendar.render();
        });
    </script>

@endsection