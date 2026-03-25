@extends('company.layout.app')

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
                            <a href="{{route('company.dashboard')}}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-white fs-6"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{route('company.seasonal_prices.index')}}" class="text-white text-hover-primary">Seasonal Prices List</a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">New Seasonal Price</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">New Seasonal Price</h1>
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
                                    <form action="{{ route('company.seasonal_prices.store') }}" class="ajax-form" method="post" id="Seasonal Price_store_form">
                                        @csrf
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column align-items-start flex-xxl-row">
                                            <!--begin::-->
                                            <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                                <span class="fs-2x fw-bold text-gray-800">New Seasonal Rate #</span>
                                            </div>
                                            <!--end::-->
                                        </div>
                                        <!--end::Top-->

                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed my-10"></div>
                                        <!--end::Separator-->

                                        <div class="mb-0">
                                            <!--begin::Row-->
                                            <div class="row gx-10 mb-5">
                                                <!--begin::Col-->
                                                <div class="col-lg-12 mt-4">
                                                    <!--begin::Input group-->
                                                    <div class="row mb-6">
                                                        <label for="title" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Start Date</span> </label>
                                                        <div class="col-lg-8 fv-row">
                                                            <input type="text" name="start_date" id="start_date" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                   placeholder="Start Date" readonly="readonly"/>
                                                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                        </div>
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group-->
                                                    <div class="row mb-6">
                                                        <label for="end_date" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>End Date</span> </label>
                                                        <div class="col-lg-8 fv-row">
                                                            <input type="text" name="end_date" id="end_date" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" required
                                                                   placeholder="End Date" readonly="readonly"/>
                                                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                        </div>
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group-->
                                                    <div class="row mb-5">
                                                        <label for="rate_multiplier" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Rate Multiplier</span> </label>
                                                        <div class="col-lg-8 fv-row">
                                                            <input type="search" name="rate_multiplier" id="rate_multiplier" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" required
                                                                   placeholder="e.g. 1.2 for +20%"/>
                                                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                        </div>
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed mb-8"></div>
                                                    <!--end::Separator-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Wrapper-->

                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="submit"  class="submit-btn-2 btn btn-primary">
                                                <i class="ki-outline ki-triangle fs-3"></i>
                                                <i class="fa fa-spinner fa-spin d-none"></i>
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Content-->
                        <!--end::Layout-->
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
                var startDate = $("#start_date").flatpickr({
                    dateFormat: "d-m-Y",
                });

                var endDate = $("#end_date").flatpickr({
                    dateFormat: "d-m-Y",
                });

            </script>
@endsection
