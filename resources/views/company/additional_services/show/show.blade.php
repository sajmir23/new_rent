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
                            <a href="{{ route('company.dashboard') }}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-white fs-6"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i></li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{ route('company.additional_services.index') }}" class="text-white text-hover-primary">
                               Additional Service List
                            </a>
                        </li>
                        <li class="breadcrumb-item"><i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i></li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            Additional Service Details
                        </li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">
                            Additional Service Details
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="app-container container-xxl">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    @include('company.additional_services.show.partials.navbar')

                    <div class="row gx-6 gx-xl-9">
                        <div class="col-lg-12">
                            <div class="card card-flush h-lg-100">
                                <div class="card-header mt-6">
                                    <div class="card-title flex-column">
                                        <h3 class="fw-bold mb-1">
                                            Id: {{ $additional_service->id }}
                                            <span class="mx-5">
                                            @if($additional_service->status)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                        </span>
                                        </h3>
                                        <div class="fs-6 text-gray-500">
                                            Created Date: {{ $additional_service->created_at }}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column p-9 pt-3 mb-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h4 class="mb-4 text-success">Title:</h4>
                                            @foreach(['en', 'it', 'al', 'es', 'de', 'fr'] as $lang)
                                                <div class="mb-3">
                                                    <strong>Title_{{$lang}}:</strong><br>
                                                    <span class="text-gray-500">
                                                    {{ $additional_service->{'title_'.$lang} ?? '--' }}
                                                </span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="mb-4 text-success">Descriptions</h4>
                                            @foreach(['en', 'it', 'al', 'es', 'de', 'fr'] as $lang)
                                                <div class="mb-3">
                                                    <strong>Description_{{$lang}}:</strong><br>
                                                    <span class="text-gray-500">
                                                    {{ $additional_service->{'description_'.$lang} ?? '--' }}
                                                </span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="mb-4 text-success">Others:</h4>
                                            <div class="mb-3">
                                                <strong>Price:</strong><br>
                                                <span class="text-gray-500">
                                                {{ $additional_service->service_price ?? '--' }} €
                                            </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

