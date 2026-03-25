@extends('company.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
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
                        <li class="breadcrumb-item text-white fw-bold lh-1">Company Data</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">
                            Company Data
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Wrapper container-->
                <div class="app-container container-xxl">
                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">
                            <!--begin::Content-->
                            <div id="kt_app_content" class="app-content flex-column-fluid">
                                @include('company.company_data.partials.navbar')
                                <!--begin::Tab Content-->
                                <div class="tab-content">
                                    <!--begin::Tab pane-->
                                    <div id="kt_project_users_card_pane" class="tab-pane fade show active">
                                        <!--begin::Row-->
                                        <div class="row g-6 g-xl-9">
                                            @foreach ($company->staff as $user)
                                                <!--begin::Col-->
                                                <div class="col-md-6 col-xxl-4">
                                                    <!--begin::Card-->
                                                    <div class="card shadow-sm border-0 rounded-3 transition-transform hover:shadow-lg hover:scale-105" style="cursor:pointer; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
                                                        <!--begin::Card body-->
                                                        <div class="card-body text-center p-10">
                                                            <!--begin::Avatar-->
                                                            <div class="symbol symbol-75px symbol-circle mb-4 mx-auto" style="border: 3px solid #0d6efd; overflow: hidden; width: 75px; height: 75px; border-radius: 50%;">
                                                                @if($user->logo)
                                                                    <img src="{{ asset('storage/' . $user->logo) }}" alt="User Photo" style="object-fit: cover; width: 75px; height: 75px;" />
                                                                @else
                                                                    <img src="{{ asset('metronic/assets/media/avatars/blank.png') }}" alt="Default Photo" style="object-fit: cover; width: 75px; height: 75px;" />
                                                                @endif
                                                            </div>
                                                            <!--end::Avatar-->
                                                            <!--begin::Avatar-->
                                                            <div class="symbol symbol-65px symbol-circle mb-5">
                                                                <div class="bg-success position-absolute border border-4 border-body h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3"></div>
                                                            </div>
                                                            <!--end::Avatar-->
                                                            <!--begin::Name-->
                                                            <h3 class="mb-1 text-gray-900 fw-bold fs-4">{{ $user->scopeFullName()}}</h3>
                                                            <!--end::Name-->
                                                            <!--begin::Info Stats-->
                                                            <div class="d-flex flex-column align-items-start gap-3 p-3 border rounded" style="background: #f9fafb; max-width: 300px; margin: 0 auto; font-size: 0.9rem;">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fas fa-envelope text-primary fs-5"></i>
                                                                    <span><strong>Email:</strong> {{ $user->email }}</span>
                                                                </div>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fas fa-phone-alt text-success fs-5"></i>
                                                                    <span><strong>Phone:</strong> {{ $user->phone_number }}</span>
                                                                </div>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fas fa-map-marker-alt text-danger fs-5"></i>
                                                                    <span><strong>Address:</strong> {{ $user->address }}</span>
                                                                </div>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fas fa-user fs-5"></i>
                                                                    <span> <strong>Status:</strong>
                                                                        @if($user->status)
                                                                            <span class="badge badge-success">Active</span>
                                                                        @else
                                                                            <span class="badge badge-danger">Inactive</span>
                                                                        @endif
                                                                      </span>
                                                                </div>
                                                            </div>
                                                            <!--end::Info Stats-->
                                                        </div>
                                                        <!--end::Card body-->
                                                    </div>
                                                    <!--end::Card-->
                                                </div>
                                                <!--end::Col-->
                                            @endforeach
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Tab pane-->
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Content wrapper-->
                    </div>
                    <!--end:::Main-->
                </div>
                <!--end::Wrapper container-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->
@endsection
