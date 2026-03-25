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
                            <a href="{{route('company.vehicles.index')}}" class="text-white text-hover-primary">Vehicle List</a>
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
                    <div class="container">
                        <div class="row mb-6">
                            <div class="col-md-8 mb-4">
                                <div class="card h-100 shadow-sm" style="min-height: 340px;">
                                    <div class="card-header border-0 mt-2">
                                        <ul class="nav nav-tabs card-header-tabs" id="vehicleTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                                        data-bs-target="#details" type="button" role="tab">
                                                    <i class="fas fa-car me-2 text-primary"></i>Vehicle Details
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="features-tab" data-bs-toggle="tab"
                                                        data-bs-target="#features" type="button" role="tab">
                                                    <i class="fas fa-plus me-2 text-primary"></i>Vehicle Features
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="requirements-tab" data-bs-toggle="tab"
                                                        data-bs-target="#requirements" type="button" role="tab">
                                                    <i class="fas fa-tasks me-2 text-warning"></i>Requirements
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body pt-3">
                                        <div class="tab-content" id="vehicleTabsContent">
                                            <!-- Details Tab -->
                                            <div class="tab-pane fade show active" id="details" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <table class="table table-borderless mb-0">
                                                            <tbody>
                                                            <tr><th class="text-muted">Title:</th><td>{{ $vehicle->title ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Brand:</th><td>{{ $vehicle->vehicleModel->brands->title ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Model:</th><td>{{ $vehicle->vehicleModel->title ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Year:</th><td>{{ $vehicle->year ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Plate No:</th><td>{{ $vehicle->plate ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Vin:</th><td>{{ $vehicle->vin ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Seats:</th><td>{{ $vehicle->seats ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Engine:</th><td>{{ $vehicle->engine_size ?? '--' }}</td></tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-6">
                                                        <table class="table table-borderless mb-0">
                                                            <tbody>
                                                            <tr><th class="text-muted">Mileage:</th><td>{{ $vehicle->mileage ? number_format($vehicle->mileage) : '--' }} Km</td></tr>
                                                            <tr><th class="text-muted">Color:</th><td>{{ $vehicle->color ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Vehicle Category:</th><td>{{ $vehicle->vehicleCategory->title_en ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Fuel Type:</th><td>{{ $vehicle->fuelType->title_en ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Transmission Type:</th><td>{{ $vehicle->transmissionType->title_en ?? '--' }}</td></tr>
                                                            <tr><th class="text-muted">Vehicle Status:</th>
                                                                <td>
                                            <span style="
                                                color: {{ $vehicle->vehicleStatus->text_color }};
                                                background-color: {{ $vehicle->vehicleStatus->background_color }};
                                                padding: 0.25em 0.5em;
                                                border-radius: 0.25rem;
                                                font-weight: 600;
                                                display: inline-block;
                                            " class="badge">{{ $vehicle->vehicleStatus->title_en ?? '--' }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr><th class="text-muted">Price/Day:</th><td>{{ $vehicle->base_daily_rate ?? '--' }} € </td></tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Features Tab -->
                                            <div class="tab-pane fade" id="features" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-12">
                                                        @if($vehicle->features && $vehicle->features->count())
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @foreach($vehicle->features as $feature)
                                                                    <span class="btn bg-light-primary px-3 py-2 fs-6">
                                                {{ $feature->title ?? '--' }}
                                            </span>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="text-center text-muted py-5">
                                                                No features available for this vehicle.
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Requirements Tab -->
                                            <div class="tab-pane fade" id="requirements" role="tabpanel">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                    <tr><th class="text-muted">Min Age:</th><td>{{ $vehicle->min_drive_age ?? '--' }}</td></tr>
                                                    <tr><th class="text-muted">Max Age:</th><td>{{ $vehicle->max_drive_age ?? '--' }}</td></tr>
                                                    <tr><th class="text-muted">International Licence Required:</th>
                                                        <td>
                                                            @if($vehicle->international_licence_required)
                                                                <span class="badge bg-success">Yes</span>
                                                            @else
                                                                <span class="badge bg-danger">No</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Vehicle Images -->
                            <div class="col-md-4 mb-4 bg-white">
                                    @if($vehicle->images && $vehicle->images->count())
                                        @if($vehicle->images->count() > 1)
                                            <div id="vehicleImagesCarousel" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($vehicle->images as $index => $image)
                                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('storage/' . $image->path) }}"
                                                                 class="d-block w-100"
                                                                 style="object-fit: contain; max-height: 400px; background-color: #f8f9fa;"
                                                                 alt="{{ $image->name }}">
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Overlay arrows -->
                                                <button class="carousel-control-prev" type="button" data-bs-target="#vehicleImagesCarousel" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#vehicleImagesCarousel" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>

                                        @else
                                            <img src="{{ asset('storage/' . $vehicle->images->first()->path) }}"
                                                 class="img-fluid w-100 rounded"
                                                 style="object-fit: contain; max-height: 400px; background-color: #f8f9fa;"
                                                 alt="{{ $vehicle->images->first()->name }}">
                                        @endif
                                    @else
                                        <div class="text-center text-muted py-5">
                                            No images uploaded for this vehicle.
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
{{--                        <div class="card h-100 shadow-sm">--}}
{{--                            <div class="card-header border-0">--}}
{{--                                <h2 class="card-title fs-3">--}}
{{--                                    <i class="fas fa-image me-2 text-success"></i>Vehicle Images--}}
{{--                                </h2>--}}
{{--                            </div>--}}
{{--                            <div class="card-body pt-3">--}}
{{--                                <div class="table-responsive">--}}
{{--                                    <!--begin::Table-->--}}
{{--                                    <table class="table table-bordered mt-5">--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th>ID</th>--}}
{{--                                            <th>File Name</th>--}}
{{--                                            <th>Size</th>--}}
{{--                                            <th>Created By</th>--}}
{{--                                            <th>Type</th>--}}
{{--                                            <th>Actions</th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}
{{--                                        @foreach ($vehicle->images as $image)--}}
{{--                                            <tr data-id="{{ $image->id }}" data-path="{{ Storage::url($image->path) }}"--}}
{{--                                                data-type="{{ pathinfo($image->path, PATHINFO_EXTENSION) }}">--}}
{{--                                                <td>{{ $loop->iteration }}</td>--}}
{{--                                                <td data-id="{{ $image->id }}">{{ basename($image->name) }}</td>--}}
{{--                                                <td>{{ number_format($image->size) }} KB</td>--}}
{{--                                                <td>{{ $image->creator ? $image->creator->fullName() : "--" }}</td>--}}
{{--                                                <td>{{ $image->mime }}</td>--}}
{{--                                                <td>--}}
{{--                                                    <div class="d-flex flex-shrink-0">--}}
{{--                                                        <a href="javascript:void(0)" class=" btn-preview btn btn-icon btn-bg-light btn-primary btn-sm me-1">--}}
{{--                                                            <i class="ki-outline ki-eye fs-2"></i>--}}
{{--                                                        </a>--}}
{{--                                                        <br>--}}
{{--                                                        <a href="{{ Storage::url($image->path) }}" target="_blank" class="btn btn-icon btn-bg-light btn-warning btn-sm me-1">--}}
{{--                                                            <i class="ki-outline ki-arrow-down fs-2"></i>--}}
{{--                                                        </a>--}}

{{--                                                        <a onclick="showDeleteModal({{$image->id}})" data-id="{{$image->id}}"  class="btn btn-icon btn-bg-light btn-danger btn-sm">--}}
{{--                                                            <i class="ki-outline ki-trash fs-2"></i>--}}
{{--                                                        </a>--}}

{{--                                                    </div>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                <!--end::Content-->
                </div>
            <!--end::Content wrapper-->
        </div>
        <!--end:::Main-->
    </div>
@endsection
@section('custom-js')
@endsection
