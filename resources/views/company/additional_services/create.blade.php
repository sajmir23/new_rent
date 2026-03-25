@extends('company.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/datatables/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/datatables/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
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
                        <li class="breadcrumb-item text-white fw-bold lh-1">Additional Services List</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Additional Services List</h1>
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

                    <div class="row gx-6 gx-xl-9">
                        <div class="col-lg-12">
                            <div class="card card-flush h-lg-100">
                                <div class="card-header mt-6">
                                    <div class="card-title flex-column">
                                        <h3 class="fw-bold mb-1">New Additional Service</h3>
                                    </div>
                                </div>

                                <form action="{{ route('company.additional_services.store') }}" method="POST" class="ajax-form" id="additional_services_store_form">
                                    @csrf

                                    <div class="card-body d-flex flex-column p-9 pt-3 mb-9">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="col-12 col-md-10">
                                                    <h4 class="mb-4 text-success">Title</h4>
                                                    @foreach(['en', 'it', 'al', 'es', 'de', 'fr'] as $lang)
                                                        <div class="mb-3">
                                                            <label for="title_{{ $lang }}" class="fw-semibold">Title En</label>
                                                            <input type="search" name="title_{{ $lang }}" id="title_{{ $lang }}"
                                                                   class="form-control form-control-lg form-control-solid"
                                                                   placeholder="Title_{{ $lang }}">
                                                            <span class="invalid-feedback"><strong></strong></span>
                                                        </div>
                                                    @endforeach
                                                    <h4 class="mt-10 mb-4 text-success">Other</h4>
                                                    <div class="mb-3">
                                                        <label for="deposit_price" class="fw-semibold">Price (€)</label>
                                                        <input type="number" name="service_price" id="service_price"
                                                               class="form-control form-control-lg form-control-solid"
                                                               placeholder="Price">
                                                        <span class="invalid-feedback"><strong></strong></span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="mb-4 text-success">Description</h4>
                                                @foreach(['en', 'it', 'al', 'es', 'de', 'fr'] as $lang)
                                                    <div class="mb-3">
                                                        <label for="description_{{ $lang }}" class="fw-semibold">Description ({{ strtoupper($lang) }})</label>
                                                        <textarea name="description_{{ $lang }}" id="description_{{ $lang }}"
                                                                  class="form-control form-control-lg form-control-solid"
                                                                  placeholder="Enter description in {{ strtoupper($lang) }}" rows="3"></textarea>
                                                        <span class="invalid-feedback"><strong></strong></span>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="submit-btn-2 btn btn-primary">
                                            <i class="ki-outline ki-triangle fs-3"></i>
                                            <i class="fa fa-spinner fa-spin d-none"></i>
                                            @lang('master.save')
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-js')
    <script>
        $(function () {
            $('#has_theft_protection').change(function () {
                $('#theft_protection_price').closest('.mb-5').toggle(this.checked);
            }).trigger('change');

            $('#has_deposit').change(function () {
                $('#deposit_price').closest('.mb-5').toggle(this.checked);
            }).trigger('change');
        });
    </script>
@endsection
