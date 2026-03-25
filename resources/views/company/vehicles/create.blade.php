@extends('company.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--Filepond-->
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet" />

    <style>
        .filepond--item {
            width: calc(25% - 0.5em) !important;
        }
    </style>
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
                            <a href="{{route('company.vehicles.index')}}" class="text-white text-hover-primary">Vehicles List</a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">New Vehicle</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">New Vehicle</h1>
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
                    <!--begin::Layout-->
                    <div class="d-flex flex-column flex-lg-row">
                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                            <!--begin::Card-->
                            <div class="card">
                                <!--begin::Card body-->
                                <div class="card-body p-12">
                                    <!--begin::Form-->
                                    <form action="{{route('company.vehicles.store')}}" class="ajax-form"  method="post" id="vehicle_store_form">
                                        @csrf
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column align-items-start flex-xxl-row">
                                            <!--Order Date-->
                                            <div class="d-flex align-items-center flex-equal fw-row me-4 order-2"
                                                 data-bs-toggle="tooltip"
                                                 data-bs-trigger="hover" data-bs-original-title="Specify order date" data-kt-initialized="1">
                                                <!--begin::Date-->
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap">Registration Expiry:</div>
                                                <!--end::Date-->
                                                <!--begin::Input-->
                                                <div class="position-relative d-flex align-items-center w-150px">
                                                    <!--begin::Datepicker-->
                                                    <input class="form-control form-control-transparent fw-bold pe-5 flatpickr-input"
                                                           placeholder="Select date"
                                                           name="registration_expiry"
                                                           id="registration_expiry" type="text" readonly="readonly">
                                                    <!--end::Datepicker-->
                                                    <!--begin::Icon-->
                                                    <i class="ki-outline ki-down fs-4 position-absolute ms-4 end-0"></i>                        <!--end::Icon-->
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Order date-->

                                            <!--begin::Input group-->
                                            <div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row"
                                                 data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                 data-bs-original-title="Specify invoice due date" data-kt-initialized="1">
                                                <!--begin::Date-->
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap">Insurance Expiry:</div>
                                                <!--end::Date-->

                                                <!--begin::Input-->
                                                <div class="position-relative d-flex align-items-center w-150px">
                                                    <!--begin::Datepicker-->
                                                    <input class="form-control form-control-transparent fw-bold pe-5 flatpickr-input" placeholder="Select date" name="insurance_expiry"
                                                           type="text" readonly="readonly" id="insurance_expiry">
                                                    <!--end::Datepicker-->

                                                    <!--begin::Icon-->
                                                    <i class="ki-outline ki-down fs-4 position-absolute end-0 ms-4"></i>
                                                    <!--end::Icon-->
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Top-->
                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed my-10"></div>
                                        <!--end::Separator-->
                                        <!--begin::Wrapper-->
                                        <div class="mb-0">
                                            <!--begin::Row-->
                                            <div class="row gx-10 mb-5">
                                                <!--begin::Col-->
                                                <div class="col-lg-6">
                                                    <!--begin::Plate-->
                                                    <div class="mb-5">
                                                        <label for="plate" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span >Plate</span> </label>
                                                        <input type="search" name="plate" id="plate" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Plate"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <!--end::Plate-->

                                                    <div class="mb-5">
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <label for="title" class=" col-form-label fw-semibold fs-6">
                                                                    <span class="required">Vehicle Status</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <select name="vehicle_status_id" id="vehicle_status_id" aria-label="Select a Status" data-control="select2"
                                                                data-placeholder="Select a status..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        </select>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>

                                                    <!--begin::Daily Rate-->
                                                    <div class="mb-5">
                                                        <label for="base_daily_rate" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span class="required">Base Daily Rate (€)</span> </label>
                                                        <input type="number" name="base_daily_rate" id="base_daily_rate" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Daily Rate"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <!--end::begin::Daily Rate-->

                                                    <!--begin::Year-->
                                                    <div class="mb-5">
                                                        <label for="year" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span class="required">Year</span> </label>
                                                        <input type="number" name="year" id="year" min="0" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Year"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <!--end::Year-->

                                                    <!--begin::Vehicle Color-->
                                                    <div class="mb-5">
                                                        <label for="color" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Color</span> </label>
                                                        <input type="search" name="color" id="color" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Color"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <!--end::Vehicle Color-->
                                                    <div class="mb-5">
                                                        <label for="engine_size" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Engine Size</span> </label>
                                                        <input type="search" name="engine_size" id="engine_size" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Engine"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Col-->

                                                <!--begin::Col-->
                                                <div class="col-lg-6">

                                                    <!--begin::Vin-->
                                                    <div class="mb-5">

                                                        <div class="row">
                                                            <div class="col-8">
                                                                <label for="title" class=" col-form-label fw-semibold fs-6">
                                                                    <span>VIN</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <input type="search" name="vin" id="vin" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Vin"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <!--end::Vin-->
                                                    <div class="mb-5">
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <label for="vehicle_model_id" class=" col-form-label fw-semibold fs-6 required">
                                                                    <span>Model</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <select name="vehicle_model_id" id="vehicle_model_id" aria-label="Select a Vehicle Model" data-control="select2"
                                                                data-placeholder="Select a Vehicle Model..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        </select>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>

                                                    <div class="mb-5">
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <label for="vehicle_category_id" class=" col-form-label fw-semibold fs-6 required">
                                                                    <span>Vehicle Category </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <select name="vehicle_category_id" id="vehicle_category_id" aria-label="Select a Category" data-control="select2"
                                                                data-placeholder="Select a Category..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        </select>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>


                                                    <div class="mb-5">
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <label for="fuel_type_id" class=" col-form-label fw-semibold fs-6 required">
                                                                    <span>Fuel Type </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <select name="fuel_type_id" id="fuel_type_id" aria-label="Select a Fuel Type" data-control="select2"
                                                                data-placeholder="Select a Fuel Type..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        </select>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>



                                                    <div class="mb-5">
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <label for="transmission_type_id" class=" col-form-label fw-semibold fs-6 required">
                                                                    <span>Transmission Type</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <select name="transmission_type_id" id="transmission_type_id" aria-label="Select a Transmission Type" data-control="select2"
                                                                data-placeholder="Select a Transmission Type..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        </select>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>

                                                    <div class="mb-5">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <!--begin::Seats-->
                                                                <div class="mb-5">
                                                                    <label for="seats" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                                        <span>Seats</span> </label>
                                                                    <input type="number" name="seats" id="seats" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                           placeholder="Seats" min="1"/>
                                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                                </div>
                                                                <!--end::Seats-->
                                                            </div>
                                                            <div class="col-6">
                                                                <!--begin::Plate-->
                                                                <div class="mb-5">
                                                                    <label for="mileage" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                                        <span>Mileage</span> </label>
                                                                    <input type="number" name="mileage" id="mileage" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                           placeholder="Mileage" min="1"/>
                                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                                </div>
                                                                <!--end::Plate-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                            <div class="my-15">
                                                <h2 class="mb-8">Features & Requirements</h2>
                                                    <div class="row">
                                                        @foreach($features as $feature)
                                                            <div class="col-md-12 col-lg-3 mb-8">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="features[]"
                                                                           value="{{ $feature->id }}" id="feature-{{ $feature->id }}">

                                                                    <label class="form-check-label" for="feature-{{ $feature->id }}">
                                                                        {{ $feature->title }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                <div class="row mt-8">
                                                    <div class="col-md-12 col-lg-4 mb-8">
                                                        <label for="min_drive_age" class="col-lg-12 col-form-label fw-semibold fs-6">
                                                            <span>Min Drive Age</span> </label>
                                                        <input type="number" name="min_drive_age" id="min_drive_age" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Ex. 18" min="18"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <div class="col-md-12 col-lg-4 mb-8">
                                                        <label for="max_drive_age" class="col-lg-12 col-form-label fw-semibold fs-6">
                                                            <span>Max Drive Age</span> </label>
                                                        <input type="number" name="max_drive_age" id="max_drive_age" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Ex. 70" max="90"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <div class="col-md-12 col-lg-1 mb-8">
                                                    </div>
                                                    <div class="col-md-12 col-lg-3 mt-15">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="international_licence_required"
                                                                   value="1" id="international_licence_required">

                                                            <label class="form-check-label fs-6" for="international_licence_required">
                                                                International Licence Required
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fs-6 fw-bold text-gray-700">Notes</label>
                                                <textarea name="notes" class="form-control form-control-solid" rows="3" placeholder="Thanks for your business"></textarea>
                                            </div>

                                        <div class="my-15">

                                            <input type="file" id="vehicle_images" multiple>
                                            <input type="hidden" name="images" id="images_input">
                                        </div>
                                        <!--end::Wrapper-->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="submit"  class="submit-btn-2 btn btn-primary">
                                                <i class="ki-outline ki-triangle fs-3"></i>
                                                <i class="fa fa-spinner fa-spin d-none"></i>Save</button>
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
    @include('company.vehicles.custom_js')

    <script>
        var registrationExpiry   = $("#registration_expiry").flatpickr();
        var insuranceExpiry      = $("#insurance_expiry").flatpickr();

    </script>


    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

    <script>
        // Register the preview plugin
        FilePond.registerPlugin(FilePondPluginImagePreview);

        let uploadedTempIds = [];

        const pond = FilePond.create(document.querySelector('#vehicle_images'), {
            allowMultiple: true,
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort) => {

                    const formData = new FormData();
                    formData.append('file', file);

                    axios.post("{{ route('company.vehicles.image_store') }}", formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then((response) => {
                            const data = response.data;

                            uploadedTempIds.push(data.id);

                            // Save comma-separated IDs (not JSON)
                            document.querySelector('#images_input').value = uploadedTempIds.join(',');

                            load(data.id); // tell FilePond upload finished
                        })
                        .catch(() => {
                            error("Upload failed");
                        });
                }
            }
        });
    </script>

@endsection