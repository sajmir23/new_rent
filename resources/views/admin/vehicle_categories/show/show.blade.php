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
                            <a href="{{route('admin.vehicle_categories.index')}}" class="text-white text-hover-primary">Vehicle Categories List</a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Vehicle Category Details</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Vehicle Category Details</h1>
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
                    @include('admin.vehicle_categories.show.partials.navbar')
                    
                    <div class="row gx-6 gx-xl-9">
                        <!--begin::Col-->
                        <div class="col-lg-12">
                            <!--begin::Card-->
                            <div class="card  card-flush h-lg-100">
                                <!--begin::Card header-->
                                <div class="card-header mt-6">
                                    <!--begin::Card title-->
                                    <div class="card-title flex-column">
                                        <h3 class="fw-bold mb-1">Id : {{$vehicle_category->id}}
                                            <span class="mx-5">
                                            @if($vehicle_category->status == true)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                        </span>
                                        </h3>

                                        <div class="fs-6 text-gray-500">Created Date : {{$vehicle_category->created_at}}</div>


                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card toolbar-->

                                <!--begin::Card body-->
                                <div class="card-body d-flex flex-column p-9 pt-3 mb-9">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <!--begin::Item-->
                                            <div class="row g-5 mb-5 align-items-start">
                                                <div class="col">
                                                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-4">
                                                        @php
                                                        $languages=['en','it','al','es','de','fr']
                                                        @endphp
                                                        @foreach($languages as $lang)
                                                            <div class="col">
                                                                <div class="d-flex align-items-start gap-3">
                                                                    <i class="fa fa-genderless text-success fs-1 mt-1"></i>
                                                                    <div>
                                                                        <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Title {{ strtoupper($lang) }}</a>
                                                                        <div class="text-gray-500">
                                                                            {{ $vehicle_category->{'title_' . $lang} ?: '--' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            {{--<div class="d-flex align-items-center mb-5">
                                                <div class="me-5 position-relative">
                                                    <div class="me-5 position-relative">
                                                        <i class="fa fa-genderless text-success fs-1"></i>
                                                    </div>
                                                </div>
                                                <div class="fw-semibold">
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Icon</a>

                                                    <div class="text-gray-500">
                                                        <ul>
                                                            <li>
                                                                <a href="{{ Storage::url($vehicle_category->icon) }}" target="_blank">
                                                                    {{ basename($vehicle_category->icon) }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>--}}
                                            <!--end::Item-->
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
        </div>
        <!--end:::Main-->
    </div>
@endsection
