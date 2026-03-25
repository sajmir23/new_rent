@extends('company.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

    <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

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
                        <li class="breadcrumb-item text-white fw-bold lh-1">Vehicle Details</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Vehicle Details</h1>
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
                    @include('company.vehicles.show.partials.navbar')

                    <!--begin::Content-->
                    <div class="row gx-6 gx-xl-9 mt-5">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <!--begin::Form-->
                                <form action="{{route('company.vehicles.update',$vehicle->id)}}" class="ajax-form"  method="post" id="vehicle_update_form">
                                    @csrf
                                    @method('PUT')
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
                                                       id="registration_expiry"
                                                       value="{{ $vehicle->registration_expiry }}"
                                                       type="text" readonly="readonly">
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
                                                <input class="form-control form-control-transparent fw-bold pe-5 flatpickr-input"
                                                       placeholder="Select date"
                                                       name="insurance_expiry"
                                                       id="insurance_expiry"
                                                       value="{{ $vehicle->insurance_expiry }}"
                                                       type="text" readonly="readonly">
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
                                                    <input type="search" name="plate" id="plate" value="{{ $vehicle->plate }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Plate"/>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                                <!--end::Plate-->

                                                <!--begin::Daily Rate-->
                                                <div class="mb-5">
                                                    <label for="base_daily_rate" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span class="required">Base Daily Rate (€)</span> </label>
                                                    <input type="number" name="base_daily_rate" id="base_daily_rate" value="{{ $vehicle->base_daily_rate }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Base Daily Rate"/>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                                <!--end::begin::Daily Rate-->

                                                <!--begin::Year-->
                                                <div class="mb-5">
                                                    <label for="year" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span class="required">Year</span> </label>
                                                    <input type="number" name="year" id="year" min="0" value="{{ $vehicle->year }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Year"/>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                                <!--end::Year-->

                                                <div class="mb-5">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <label for="title" class=" col-form-label fw-semibold fs-6">
                                                                <span>Vehicle Status</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <select name="vehicle_status_id" id="vehicle_status_id" aria-label="Select a Status" data-control="select2"
                                                            data-placeholder="Select a status..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        <option value="{{ old('vehicle_status_id', $vehicle->vehicle_status_id ?? '') }}" selected hidden>
                                                            {{ old('vehicle_status_id', $vehicle->vehicleStatus->{"title_en"} ?? 'Select Status') }}
                                                        </option>
                                                    </select>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>

                                                <!--begin::Vehicle Color-->
                                                <div class="mb-5">
                                                    <label for="color" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Color</span> </label>
                                                    <input type="search" name="color" id="color" value="{{ $vehicle->color }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Color"/>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                                <!--end::Vehicle Color-->
                                                <!--begin::Vehicle Engine-->
                                                <div class="mb-5">
                                                    <label for="engine_size" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Engine Size</span> </label>
                                                    <input type="search" name="engine_size" id="engine_size" value="{{ $vehicle->engine_size }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Engine"/>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                                <!--end::Vehicle Engine-->

                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Col-->
                                            <div class="col-lg-6">

                                                <!--begin::Vin-->
                                                <div class="mb-5">

                                                    <div class="row">
                                                        <div class="col-8">
                                                            <label for="title" class=" col-form-label fw-semibold fs-6">
                                                                <span>Vin</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <input type="search" name="vin" id="vin" value="{{ $vehicle->vin }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           placeholder="Vin"/>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                                <!--end::Vin-->
                                                <div class="mb-5">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <label for="vehicle_model_id" class="col-form-label fw-semibold fs-6 required">
                                                                <span>Model</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <select name="vehicle_model_id" id="vehicle_model_id" aria-label="Select a Vehicle Model" data-control="select2"
                                                            data-placeholder="Select a Vehicle Model..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        <option value="{{ old('vehicle_model_id', $vehicle->vehicle_model_id ?? '') }}" selected hidden>
                                                            {{ old('vehicle_model_id', $vehicle->vehicleModel->title ?? 'Select Model') }}
                                                        </option>
                                                    </select>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>

                                                <div class="mb-5">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <label for="vehicle_category_id" class=" col-form-label fw-semibold fs-6 required">
                                                                <span>Vehicle Category</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <select name="vehicle_category_id" id="vehicle_category_id" aria-label="Select a Category" data-control="select2"
                                                            data-placeholder="Select a Category..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        <option value="{{ old('vehicle_category_id', $vehicle->vehicle_category_id ?? '') }}" selected hidden>
                                                            {{ old('vehicle_category_id', $vehicle->vehicleCategory->{"title_en"} ?? 'Select Category') }}
                                                        </option>
                                                    </select>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>

                                                <div class="mb-5">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <label for="fuel_type_id" class=" col-form-label fw-semibold fs-6 required">
                                                                <span>Fuel Type</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <select name="fuel_type_id" id="fuel_type_id" aria-label="Select a Fuel Type" data-control="select2"
                                                            data-placeholder="Select a Fuel Type..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        <option value="{{ old('fuel_type_id', $vehicle->fuel_type_id ?? '') }}" selected hidden>
                                                            {{ old('fuel_type_id', $vehicle->FuelType->{"title_en"} ?? 'Select Fuel Type') }}
                                                        </option>
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
                                                        <option value="{{ old('transmission_type_id', $vehicle->transmission_type_id ?? '') }}" selected hidden>
                                                            {{ old('transmission_type_id', $vehicle->TransmissionType->{"title_en"} ?? 'Select Transmission Type') }}
                                                        </option>
                                                    </select>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                                <!--begin::Plate-->
                                                <div class="mb-5">
                                                    <div class="row">
                                                        <div class=" col-6">
                                                            <label for="mileage" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                                <span>Mileage</span> </label>
                                                            <input type="number" name="mileage" id="mileage" value="{{ $vehicle->mileage }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                   placeholder="Mileage"/>
                                                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                        </div>
                                                    <div class=" col-6">
                                                        <label for="seats" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Seats</span> </label>
                                                        <input type="number" name="seats" id="seats" value="{{ $vehicle->seats }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Seats"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Plate-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="my-15">
                                                    <h2 class="mb-8">Features</h2>
                                                    <div class="row">
                                                        @foreach($features as $feature)
                                                            <div class="col-md-12 col-lg-3 mb-8">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="features[]"
                                                                           value="{{ $feature->id }}" id="feature-{{ $feature->id }}"
                                                                            {{ $vehicle->features->contains($feature->id) ? 'checked' : '' }}>
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
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                        <div class="mb-5">
                                            <label class="form-label fs-6 fw-bold text-gray-700">Notes</label>

                                            <textarea name="notes" class="form-control form-control-solid" rows="3" placeholder="Thanks for your business">{{$vehicle->notes}}</textarea>
                                        </div>
                                        <div class="my-5">
                                            <input type="file"
                                                   id="vehicle_images"
                                                   name="vehicle_images"
                                                   multiple>

                                            <input type="hidden" id="images_input" name="images">
                                            <input type="hidden" id="deleted_images" name="deleted_images">
                                        </div>
                                    <!--end::Wrapper-->
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit"  class="submit-btn-2 btn btn-primary">
                                            <i class="ki-outline ki-triangle fs-3"></i>
                                            <i class="fa fa-spinner fa-spin d-none"></i>Update</button>
                                    </div>
                                        </div>
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
        var registrationExpiry   = $("#registration_expiry").flatpickr();
        var insuranceExpiry      = $("#insurance_expiry").flatpickr();
    </script>

    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>


    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);

        let uploadedTempIds = [];
        let deletedImageIds = [];

        const pond = FilePond.create(document.querySelector("#vehicle_images"), {

            allowMultiple: true,

            files: [
                    @foreach($vehicle->images as $img)
                {
                    source: "{{ asset('storage/'.$img->path) }}",
                    options: {
                        type: "local",
                        metadata: {
                            serverId: "{{ $img->id }}" // DB IMAGE ID
                        }
                    }
                },
                @endforeach
            ],

            server: {
                load: (source, load, error) => {
                    fetch(source)
                        .then(r => r.blob())
                        .then(load)
                        .catch(() => error("Failed"));
                },

                process: (fieldName, file, metadata, load, error) => {
                    let formData = new FormData();
                    formData.append("file", file);

                    axios.post("{{ route('company.vehicles.image_store') }}", formData)
                        .then(res => {
                            uploadedTempIds.push(res.data.id);
                            document.querySelector('#images_input').value = uploadedTempIds.join(",");
                            load(res.data.id); // TEMP ID
                        })
                        .catch(() => error("Upload failed"));
                },

                revert: (serverId, load) => {
                    // Do NOTHING here except clear the upload
                    load();
                }
            }
        });

        // 🔥 RELIABLE DELETE HANDLER
        pond.on('removefile', (error, file) => {

            let serverId =
                file.getMetadata('serverId') || // DB image ID
                file.serverId ||                // temp upload returned ID
                null;

            if (!serverId) return;

            // DB image (numeric)
            if (/^\d+$/.test(serverId)) {
                deletedImageIds.push(serverId);
                document.querySelector('#deleted_images').value = deletedImageIds.join(",");
            }

            // TEMP image (filename)
            else {
                uploadedTempIds = uploadedTempIds.filter(id => id !== serverId);
                document.querySelector('#images_input').value = uploadedTempIds.join(",");
            }
        });
    </script>

    @include('company.vehicles.custom_js')
@endsection
