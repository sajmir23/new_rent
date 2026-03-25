@extends('company.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

    <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>


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
                            <a href="{{route('company.deliveries.index')}}" class="text-white text-hover-primary">Deliveries List</a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Delivery Details</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Delivery Details</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="app-container  container-xxl ">
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content  flex-column-fluid ">
                    @include('company.deliveries.show.partials.navbar')

                    <!--begin::Content-->
                    <div class="row gx-6 gx-xl-9 mt-5">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <!--begin::Form-->
                                <form action="{{route('company.deliveries.update',$delivery->id)}}" class="ajax-form"  method="post" id="location_store_form">
                                    @csrf
                                    @method('PUT')

                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column align-items-start flex-xxl-row">
                                        <!--begin::ref number-->
                                        <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                            <span class="fs-2x fw-bold text-gray-800">Update Delivery #</span>
                                        </div>
                                        <!--end::ref number-->
                                    </div>
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed my-10"></div>
                                    <!--end::Separator-->

                                    <!--begin::Wrapper-->
                                    <div class="mb-0">
                                        <!--begin::Row-->
                                        <div class="row gx-10 mb-5">
                                            <!-- City -->
                                            <div class="row mb-6">
                                                <label for="city_id" class="col-lg-4 col-form-label fw-semibold fs-6 required">
                                                    <span>City</span>
                                                </label>
                                                <div class="col-lg-8 fv-row">
                                                    <select name="city_id" id="city_id" aria-label="Select a City" data-control="select2"
                                                            data-placeholder="Select a City..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        <option value="{{ old('city_id', $delivery->city_id ?? '') }}" selected hidden>
                                                            {{ old('city_id', $delivery->city->name ?? 'Select City') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Place -->
                                            <div class="row mb-6">
                                                <label for="place" class="col-lg-4 col-form-label fw-semibold fs-6 required">
                                                    <span>Place</span>
                                                </label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="search" name="place" id="place"
                                                           value="{{ old('place', $delivery->place ?? '') }}"
                                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Place"/>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                            </div>

                                            <!-- Price -->
                                            <div class="row mb-6">
                                                <label for="price" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                    <span>Price</span>
                                                </label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="number" name="price" id="price"
                                                           value="{{ old('price', $delivery->price ?? '') }}"
                                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Price"/>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                            </div>

                                            <!-- Delivery Time -->
                                            <div class="row mb-6">
                                                <label for="delivery_time" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                    <span>Delivery Time</span>
                                                </label>
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" name="delivery_time" id="delivery_time"
                                                           value="{{ old('delivery_time', $delivery->delivery_time ? \Carbon\Carbon::parse($delivery->delivery_time)->format('H:i') : '') }}"
                                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Minutes needed for delivery"/>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                            </div>

                                            <!-- Separator -->
                                            <div class="separator separator-dashed mb-8"></div>
                                        </div>

                                        <!--end::Row-->
                                    </div>
                                    <!--end::Wrapper-->

                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit"  class="submit-btn-2 btn btn-primary">
                                            <i class="ki-outline ki-triangle fs-3"></i>
                                            <i class="fa fa-spinner fa-spin d-none"></i>Update</button>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
        </div>
        <!--end:::Main-->
    </div>
@endsection
@section('custom-js')
    <script>
        $("#delivery_time").flatpickr({
            enableTime: true,   // allows time selection
            noCalendar: true,   // hides the calendar
            dateFormat: "H:i",  // 24-hour format (use "h:i K" for 12-hour with AM/PM)
            time_24hr: true     // optional: force 24-hour format
        });
    </script>

    <script>
        $(document).ready(function () {
            var $city_id = $('#city_id');
            $city_id.select2({
                placeholder: "User",
                allowClear: true,
                ajax: {
                    url: "{{ route('company.city.search') }}",
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
@endsection
