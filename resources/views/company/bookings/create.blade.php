@extends('company.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

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
                        <li class="breadcrumb-item text-white fw-bold lh-1">New Booking
                        </li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">New Booking</h1>
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
                            <!--begin::Card-->
                            <div class="card">
                                <!--begin::Card body-->
                                <div class="card-body p-12">
                                    <form action="{{ route('company.bookings.store') }}" method="POST"  id="booking_store_form"  novalidate>
                                        @csrf
                                        <!-- Client Information -->
                                        <div class="mb-10">
                                            <h3 class="fw-bold mb-5">
                                                <i class="bi bi-person-lines-fill me-2"></i> Client Information
                                            </h3>

                                            <div class="row row-cols-1 row-cols-md-2 gx-4 gy-4">
                                                <div class="col-lg-4">
                                                    <label for="first_name" class="form-label fw-semibold required">
                                                        <i class="bi bi-person-fill"></i> First Name
                                                    </label>
                                                    <input type="search" name="first_name" id="first_name" class="form-control form-control-lg form-control-solid" placeholder="First Name" required>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="last_name" class="form-label fw-semibold required">
                                                        <i class="bi bi-person-fill"></i> Last Name
                                                    </label>
                                                    <input type="search" name="last_name" id="last_name" class="form-control form-control-lg form-control-solid" placeholder="Last Name" required>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="birthday" class="form-label fw-semibold required">
                                                        <i class="bi bi-calendar-event-fill"></i> Birthday
                                                    </label>
                                                    <input type="date" name="birthday" id="birthday" class="form-control form-control-lg form-control-solid" required>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="email" class="form-label fw-semibold">
                                                        <i class="bi bi-envelope-fill"></i> Email
                                                    </label>
                                                    <input type="email" name="email" id="email" class="form-control form-control-lg form-control-solid" placeholder="example@mail.com">
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="phone" class="form-label fw-semibold required">
                                                        <i class="bi bi-telephone-fill"></i> Phone
                                                    </label>
                                                    <input type="tel" name="phone" id="phone" class="form-control form-control-lg form-control-solid" placeholder="+355 123 456 789" required>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="additional_phone" class="form-label fw-semibold">
                                                        <i class="bi bi-phone-vibrate-fill"></i> Additional Phone
                                                    </label>
                                                    <input type="tel" name="additional_phone" id="additional_phone" class="form-control form-control-lg form-control-solid" placeholder="+355 987 654 321">
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="ways_of_contact" class="form-label fw-semibold required">
                                                        <i class="bi bi-chat-dots me-2"></i> Ways of Contact
                                                    </label>
                                                    <select name="ways_of_contact" id="ways_of_contact" class="form-select form-select-solid form-select-lg fw-semibold" data-control="select2">
                                                        <option value="1">Whatsapp</option>
                                                        <option value="2">Telegram</option>
                                                        <option value="3">Viber</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Booking Details -->
                                        <div class="mb-10">
                                            <h3 class="fw-bold mb-5">
                                                <i class="bi bi-journal-check"></i> Booking Details
                                            </h3>

                                            <div class="row gx-5 gy-4">

                                                <!-- Left column -->
                                                <div class="col-md-6">

                                                    <div class="mb-4">
                                                        <label for="vehicle_id" class="form-label fw-semibold required">
                                                            <i class="bi bi-truck-front-fill"></i> Vehicle
                                                        </label>
                                                        <select name="vehicle_id" id="vehicle_id" class="form-select form-select-solid form-select-lg fw-semibold" data-control="select2" required></select>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="insurance_id" class="form-label fw-semibold required">
                                                            <i class="bi bi-shield-lock-fill"></i> Insurance
                                                        </label>
                                                        <select name="insurance_id" id="insurance_id" class="form-select form-select-solid form-select-lg fw-semibold" data-control="select2" required></select>
                                                    </div>

                                                    <!-- Additional Services -->

                                                    <div>
                                                        <label for="additional_services_select" class="form-label fw-semibold">
                                                            <i class="bi bi-tools me-2"></i> Additional Services
                                                        </label>
                                                        <select id="additional_services_select" class="form-select form-select-solid" multiple>
                                                        </select>

                                                        <div id="selected_additional_services" class="mt-3"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-1"></div>
                                                <!-- Right column -->
                                                <div class="col-md-5">

                                                    <div class="mb-4">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label for="pickup_date" class="form-label fw-semibold required">
                                                                    <i class="bi bi-calendar-check-fill"></i> Pickup Date
                                                                </label>
                                                                <input type="date" name="pickup_date" id="pickup_date" class="form-control form-control-lg form-control-solid" required>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <label for="dropoff_date" class="form-label fw-semibold required">
                                                                    <i class="bi bi-calendar-x-fill"></i> Dropoff Date
                                                                </label>
                                                                <input type="date" name="dropoff_date" id="dropoff_date" class="form-control form-control-lg form-control-solid" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label for="pickup_time" class="form-label fw-semibold">
                                                                    <i class="bi bi-clock-fill"></i> Pickup Time
                                                                </label>
                                                                <input type="text" name="pickup_time" id="pickup_time" class="form-control form-control-lg form-control-solid" placeholder="Select Time">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="dropoff_time" class="form-label fw-semibold">
                                                                    <i class="bi bi-clock-fill"></i> Dropoff Time
                                                                </label>
                                                                <input type="text" name="dropoff_time" id="dropoff_time" class="form-control form-control-lg form-control-solid" placeholder="Select Time">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="pickup_location" class="form-label fw-semibold required">
                                                            <i class="bi bi-geo-alt-fill"></i> Pickup Location
                                                        </label>
                                                        <select name="pickup_location" id="pickup_location" class="form-select form-select-solid form-select-lg fw-semibold" data-control="select2" required></select>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="dropoff_location" class="form-label fw-semibold required">
                                                            <i class="bi bi-geo-fill"></i> Dropoff Location
                                                        </label>
                                                        <select name="dropoff_location" id="dropoff_location" class="form-select form-select-solid form-select-lg fw-semibold" data-control="select2" required></select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Notes + Submit -->
                                        <div class="mt-10">
                                            <h3 class="fw-bold mb-5">
                                                <i class="bi bi-journal-text"></i> Notes & Submit
                                            </h3>

                                            <label for="notes" class="form-label fw-semibold">
                                                <i class="bi bi-pencil-square"></i> Notes
                                            </label>
                                            <textarea name="notes" id="notes" rows="4" class="form-control form-control-lg form-control-solid" placeholder="Write any additional notes here..."></textarea>

                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg px-5" id="booking_store_button">
            <span class="indicator-label">
                <i class="bi bi-save me-2"></i> Save Booking
            </span>
                                                    <span class="indicator-progress" style="display:none;">
                Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
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

    <script>
        var pickupDate = $("#pickup_date").flatpickr({
            dateFormat: "d-m-Y",
            placeholder:"Select Pick Up Time",

        });

        var dropoffDate = $("#dropoff_date").flatpickr({
            dateFormat: "d-m-Y",
            placeholder:"Select Drop Off Time",

        });

        var birthday = $("#birthday").flatpickr({
            dateFormat: "d-m-Y",
            placeholder:"Select Date",

        });

        flatpickr("#pickup_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            placeholder:"Select Time",
            time_24hr: true
        });

        flatpickr("#dropoff_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    </script>

    <script>
        $(document).ready(function () {
            var $insurance_id = $('#insurance_id');
            $insurance_id.select2({
                placeholder: "Select Insurance",
                allowClear: true,
                ajax: {
                    url: "{{ route('company.insurances.search') }}",
                    dataType: 'json',
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (source) {
                                return {
                                    id: source.id,
                                    text: source.label
                                };
                            })
                        };
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            var $vehicle_id = $('#vehicle_id');
            $vehicle_id.select2({
                placeholder: "Select Vehicle",
                allowClear: true,
                ajax: {
                    url: "{{ route('company.vehicles.search') }}",
                    dataType: 'json',
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (source) {
                                return {
                                    id: source.id,
                                    text: source.label
                                };
                            })
                        };
                    }
                }
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            var $pickup_location = $('#pickup_location');
            $pickup_location.select2({
                placeholder: "Select Location",
                allowClear: true,
                ajax: {
                    url: "{{ route('company.deliveries.search') }}",
                    dataType: 'json',
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (source) {
                                return {
                                    id: source.id,
                                    text: source.label
                                };
                            })
                        };
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            var $dropoff_location = $('#dropoff_location');
            $dropoff_location.select2({
                placeholder: "Select Location",
                allowClear: true,
                ajax: {
                    url: "{{ route('company.deliveries.search') }}",
                    dataType: 'json',
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (source) {
                                return {
                                    id: source.id,
                                    text: source.label
                                };
                            })
                        };
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#ways_of_contact').select2({
                placeholder: "Select Contact",
                allowClear: true
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#booking_store_form').on('submit', function(e) {
                e.preventDefault();

                let $button = $('#booking_store_button');
                $button.prop('disabled', true);
                $button.find('.indicator-label').hide();
                $button.find('.indicator-progress').show();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.data && response.data.success) {
                            window.location.href = response.data.redirect_to;
                        } else {
                            toastr.error('Unexpected response.');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let allErrors = [];

                            for (const field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    allErrors = allErrors.concat(errors[field]);
                                }
                            }
                            if (allErrors.length > 0) {
                                const firstError = allErrors[0];
                                const totalErrors = allErrors.length;

                                toastr.error(`${firstError} (and ${totalErrors - 1} more error${totalErrors - 1 !== 1 ? 's' : ''})`);
                            }
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                        $button.find('.indicator-label').show();
                        $button.find('.indicator-progress').hide();
                    }
                });
            });
        });
    </script>

    <script>
        $('#additional_services_select').select2({
            placeholder: "Select Additional Services",
            allowClear: true,
            ajax: {
                url: "{{ route('company.additional_services.search') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        keyword: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function(service) {
                            return {
                                id: service.id,
                                text: service.label,
                                price: service.price // IMPORTANT!
                            };
                        })
                    };
                },
                cache: true
            }
        });

        $('#additional_services_select').on('select2:select', function (e) {
            let item = e.params.data;

            // Attach price to the selected option
            let option = $(this).find(`option[value="${item.id}"]`);
            option.data('price', item.price);

            renderSelectedServices();
        });

        $('#additional_services_select').on('select2:unselect', function () {
            renderSelectedServices();
        });

        function renderSelectedServices() {
            let container = $('#selected_additional_services');
            container.empty();

            $('#additional_services_select option:selected').each(function (index, option) {
                let price = Number($(option).data('price')) || 0;

                let html = `
                <div class="d-flex align-items-center justify-content-between mb-2 service-item">

                    <label class="me-2" style="min-width: 150px;">${option.text}</label>

                    <div class="d-flex align-items-center">

                        <input type="number"
                            name="additional_services[${index}][quantity]"
                            class="form-control form-control-sm me-2 quantity-input"
                            value="1"
                            min="1"
                            style="width:70px;">

                        <span class="fw-semibold service-total">€${price.toFixed(2)}</span>

                        <input type="hidden"
                            name="additional_services[${index}][id]"
                            value="${option.value}">

                        <input type="hidden"
                            name="additional_services[${index}][price]"
                            value="${price}">
                    </div>

                </div>
            `;


                let serviceHtml = $(html);

                serviceHtml.find('.quantity-input').on('input', function () {
                    let qty = Number($(this).val()) || 0;
                    let total = (price * qty).toFixed(2);
                    $(this).siblings('.service-total').text(`€${total}`);
                });

                container.append(serviceHtml);
            });
        }

    </script>



@endsection

