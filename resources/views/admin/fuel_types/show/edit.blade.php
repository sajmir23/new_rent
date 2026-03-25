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
                            <a href="{{route('admin.fuel_types.index')}}" class="text-white text-hover-primary">Fuel Types List</a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Fuel Types Details</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Fuel Types Details</h1>
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
                    @include('admin.fuel_types.show.partials.navbar')

                    <!--begin::Content-->
                    <div class="row gx-6 gx-xl-9 mt-5">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <!--begin::Form-->
                                <form action="{{route('admin.fuel_types.update',$fuel_type->id)}}" class="ajax-form"  method="post" id="fuel_types_store_form">
                                    @csrf
                                    @method('PUT')

                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column align-items-start flex-xxl-row">
                                        <!--begin::ref number-->
                                        <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                            <span class="fs-2x fw-bold text-gray-800">Update Fuel Type #</span>
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
                                            <div class="col-lg-8">
                                                <!--begin::Image input-->
{{--                                                <div class="image-input image-input-outline" data-kt-image-input="true">--}}
{{--                                                    <!--begin::Preview existing avatar-->--}}
{{--                                                    <div class="image-input-wrapper w-125px h-125px"--}}
{{--                                                         style="background-image: url('{{ asset('storage/' . $veh->icon) }}');">--}}
{{--                                                    </div>--}}
{{--                                                    <!--end::Preview existing avatar-->--}}
{{--                                                    <!--begin::Label-->--}}
{{--                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"--}}
{{--                                                           data-kt-image-input-action="change" data-bs-toggle="tooltip"--}}
{{--                                                           aria-label="Change icon" data-bs-original-title="Change icon" data-kt-initialized="1">--}}
{{--                                                        <i class="ki-outline ki-pencil fs-7"></i>--}}
{{--                                                        <!--begin::Inputs-->--}}
{{--                                                        <input type="file" name="icon" accept=".png, .jpg, .jpeg">--}}
{{--                                                        <input type="hidden" name="avatar_remove">--}}
{{--                                                        <!--end::Inputs-->--}}
{{--                                                    </label>--}}
{{--                                                    <!--end::Label-->--}}
{{--                                                    <!--begin::Cancel-->--}}
{{--                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"--}}
{{--                                                          data-kt-image-input-action="cancel" data-bs-toggle="tooltip"--}}
{{--                                                          aria-label="Cancel avatar" data-bs-original-title="Cancel avatar" data-kt-initialized="1">--}}
{{--                                                         <i class="ki-outline ki-cross fs-2"></i>--}}
{{--                                                    </span>--}}
{{--                                                    <!--end::Cancel-->--}}
{{--                                                    <!--begin::Remove-->--}}
{{--                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"--}}
{{--                                                          data-kt-image-input-action="remove" data-bs-toggle="tooltip"--}}
{{--                                                          aria-label="Remove avatar" data-bs-original-title="Remove avatar" data-kt-initialized="1">--}}
{{--                                                          <i class="ki-outline ki-cross fs-2"></i>--}}
{{--                                                     </span>--}}
{{--                                                    <!--end::Remove-->--}}
{{--                                                </div>--}}
                                                <!--end::Image input-->
                                                <!--begin::Hint-->
{{--                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>--}}
                                                <!--end::Hint-->
                                            </div>
                                            <!--begin::Col-->
                                            <div class="col-lg-12">
                                                <!--begin::Input group-->
                                                <div class="row mb-5">
                                                    <label for="title_en" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Title En</span> </label>
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="search" name="title_en" id="title_en"
                                                               value="{{$fuel_type->title_en}}"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Title En"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-5">
                                                    <label for="title_it" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Title It</span> </label>
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="search" name="title_it" id="title_it"
                                                               value="{{$fuel_type->title_it}}"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Title It"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-5">
                                                    <label for="title_al" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Title Al</span> </label>
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="search" name="title_al" id="title_al"
                                                               value="{{$fuel_type->title_al}}"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Title Al"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-5">
                                                    <label for="title_al" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Title Es</span> </label>
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="search" name="title_es" id="title_es"
                                                               value="{{$fuel_type->title_es}}"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Title Es"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-5">
                                                    <label for="title_al" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Title Fr</span> </label>
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="search" name="title_fr" id="title_fr"
                                                               value="{{$fuel_type->title_fr}}"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Title Fr"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-5">
                                                    <label for="title_al" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Title De</span> </label>
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="search" name="title_de" id="title_de"
                                                               value="{{$fuel_type->title_de}}"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Title De"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->

                                                <div class="mb-8 mt-7">
                                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-5">
                                                          <span class="form-check-label ms-0 fw-bold fs-6 text-gray-700">Status</span>
                                                        <input class="form-check-input" @if($fuel_type->status == true) checked @endif type="checkbox" name="status">
                                                    </label>
                                                </div>
                                            </div>

                                            <!--end::Col-->
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
@endsection
