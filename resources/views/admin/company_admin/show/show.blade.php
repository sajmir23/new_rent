@extends('admin.layout.app')

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
                            <a href="{{route('admin.dashboard')}}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-gray-700 fs-6"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{route('admin.company_admin.index')}}" class="text-white text-hover-primary">
                                Company Admin List
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Company Admin Details</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Company Admin Details</h1>
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
                    @include('admin.company_admin.show.partials.navbar')

                    <div class="row g-6 mb-6">
                        <!--begin::staff Data Card-->
                        <div class="col-xl-6">
                            <div class="card card-xl-stretch shadow-sm">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="fw-bold text-danger-emphasis fs-3">User Information</span>
                                        <span class="text-muted mt-1 fw-semibold fs-6">Basic details about the user</span>
                                    </h3>
                                </div>
                                <div class="card-body pt-5">
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Full Name:</strong>
                                        <span class="text-muted">{{ $company_admin->fullName() }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Email:</strong>
                                        <span class="text-muted">{{ $company_admin->email }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Phone Number:</strong>
                                        <span class="text-muted">{{ $company_admin->phone_number }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Address:</strong>
                                        <span class="text-muted">{{ $company_admin->address }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Notes:</strong>
                                        <span class="text-muted">{{ $company_admin->notes ?: 'No notes' }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Status:</strong>
                                        <span class="badge badge-light-{{ $company_admin->status ? 'success' : 'danger' }}">
                        {{ $company_admin->status ? 'Active' : 'Inactive' }}
                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::staff Data Card-->

                        <!--begin::Admin Data Card-->
                        <div class="col-xl-6">
                            <div class="card card-xl-stretch shadow-sm">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="fw-bold text-success-emphasis fs-3">Company Information</span>
                                        <span class="text-muted mt-1 fw-semibold fs-6">Details about the company</span>
                                    </h3>
                                </div>
                                <div class="card-body pt-5">
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Name:</strong>
                                        <span class="text-muted">{{ $company_admin->company->name }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Email:</strong>
                                        <span class="text-muted">{{ $company_admin->company->email }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Phone:</strong>
                                        <span class="text-muted">{{ $company_admin->company->phone }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Address:</strong>
                                        <span class="text-muted">{{ $company_admin->company->address }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <strong class="d-block text-gray-800">Status:</strong>
                                        <span class="badge badge-light-{{ $company_admin->company->status ? 'success' : 'danger' }}">
                        {{ $company_admin->company->status ? 'Active' : 'Inactive' }}
                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Admin Data Card-->
                    </div>

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
