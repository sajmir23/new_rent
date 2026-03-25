@extends('admin.layout.app')

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
                            <a href="{{route('admin.dashboard')}}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-gray-700 fs-6"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{route('admin.permissions.index')}}" class="text-white text-hover-primary">Permissions</a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Add Permission</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Add Permission</h1>
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
                                    <form action="{{route('admin.permissions.store')}}"  method="post" id="permission_store_form">
                                        @csrf

                                        <!--begin::Wrapper-->
                                        <div class="mb-0">
                                            <!--begin::Row-->
                                            <div class="row gx-10 mb-5">
                                                <!--begin::Col-->
                                                <div class="col-lg-6">
                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <label for="name" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span class="required">Name</span> </label>
                                                        <input type="text" name="name" id="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Name"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <label for="description" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Description</span> </label>
                                                        <textarea name="description" class="form-control form-control-solid" rows="3" placeholder="Description"></textarea>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <!--end::Input group-->
                                                </div>
                                                <!--end::Col-->

                                                <div class="col-lg-6">
                                                    <!--begin::Input group-->
                                                    <div class="mb-5">
                                                        <label for="slug" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span class="required">Slug</span> </label>
                                                        <input type="text" name="slug" id="slug" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Slug"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                    <!--end::Input group-->
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                <button type="submit"  class="submit-btn-2 btn btn-primary">
                                                    <i class="ki-outline ki-triangle fs-3"></i>
                                                    <i class="fa fa-spinner fa-spin d-none"></i>Save</button>
                                            </div>
                                        </div>
                                    </form>
                                <!--end::Card-->
                            </div>
                            <!--end::Sidebar-->
                        </div>
                        <!--end::Layout-->
                    </div>
                    <!--end::Content-->

                </div>
                <!--end::Content wrapper-->
            </div>
            <!--end:::Main-->
        </div>
@endsection
