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
                        <li class="breadcrumb-item text-white fw-bold lh-1">Company Data)</li>
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
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <div class="app-container container-xxl">
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content flex-column-fluid">
                                @include('company.company_data.partials.navbar')
                                <div class="card mb-5 mb-xl-10">
                                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                                        <div class="card-title m-0">
                                            <h3 class="fw-bold m-0">Profile Details</h3>
                                        </div>
                                    </div>

                                    <form action="{{route('company.company_data.update', $company->id)}}" method="post" id="company_store_form" class="form" enctype="multipart/form-data">
                                        @csrf
                                        @method("PUT")

                                        <div class="card-body border-top p-9">
                                            <div class="col-lg-8">
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-outline" data-kt-image-input="true">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                         style="background-image: url('{{ $company->logo ? asset('storage/' . $company->logo) : asset('images/placeholder.png') }}')">
                                                    </div>
                                                    <!--end::Preview existing avatar-->

                                                    <!--begin::Label-->
                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                           data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                           aria-label="Change logo" data-bs-original-title="Change logo" data-kt-initialized="1">
                                                        <i class="ki-outline ki-pencil fs-7"></i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="logo" accept=".png, .jpg, .jpeg">
                                                        <input type="hidden" name="avatar_remove">
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->

                                                    <!--begin::Cancel-->
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                          data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                          aria-label="Cancel avatar" data-bs-original-title="Cancel avatar">
                                                         <i class="ki-outline ki-cross fs-2"></i>
                                                     </span>
                                                    <!--end::Cancel-->

                                                    <!--begin::Remove-->
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                          data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                          aria-label="Remove avatar" data-bs-original-title="Remove avatar">
                                                               <i class="ki-outline ki-cross fs-2"></i>
                                                              </span>
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Hint-->
                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                <!--end::Hint-->
                                            </div>
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Full Name</label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-6 fv-row">
                                                            <input type="search" name="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Full Name" value="{{ old('name', $company->name) }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Phone</label>
                                                <div class="col-lg-8 ">
                                                    <div class="row">
                                                        <div class="col-lg-6 fv-row">
                                                            <input type="tel" name="phone" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Phone Number" value="{{ old('phone', $company->phone) }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Email</label>
                                                <div class="col-lg-8 ">
                                                    <div class="row">
                                                        <div class="col-lg-6 fv-row">
                                                            <input type="email" name="email" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Email" value="{{ old('email', $company->email) }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Address</label>
                                                <div class="col-lg-8 ">
                                                    <div class="row">
                                                        <div class="col-lg-6 fv-row">
                                                            <input type="search" name="address" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Address" value="{{ old('address', $company->address) }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-6">
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Main Office</label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-6 fv-row">
                                                            <select name="city_id" id="city_id"
                                                                    data-control="select2"
                                                                    data-placeholder="Select City..."
                                                                    class="form-select form-select-lg form-select-solid fw-semibold">
                                                                <option value="{{ old('city_id', $company->city_id ?? '') }}" selected hidden>
                                                                    {{ old('city_id', $company->city->name ?? 'Select City') }}
                                                                </option>
                                                            </select>
                                                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <div class="col-xl-4">
                                                    <div class="fs-6 fw-semibold mt-2 mb-3">Working Days</div>
                                                </div>
                                                <div class="col-xl-8">
                                                    @foreach ($days as $day)
                                                        <div class="mb-3">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input
                                                                        class="form-check-input"
                                                                        type="checkbox"
                                                                        name="{{ $day }}"
                                                                        id="{{ $day }}"
                                                                        value="1"
                                                                        {{ in_array($day, $working_days) ? 'checked' : '' }}>
                                                                <label class="form-check-label ms-3" for="{{ $day }}">{{ ucfirst($day) }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="mb-8 mt-7">
                                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-5">
                                                <span class="form-check-label ms-0 fw-bold fs-6 text-gray-700">
                                                    @lang('master.companies.status')
                                                </span>
                                                    <div class="col-lg-4 fv-row">
                                                    <input class="form-check-input" @if($company->status) checked @endif type="checkbox" name="status" id="status">
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <a href="{{ route('company.company_data.index') }}" class="btn btn-light btn-active-light-primary me-2"> Discard </a>
                                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
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
        $(document).ready(function () {
            var $city_id = $('#city_id');
            $city_id.select2({
                placeholder: "User",
                allowClear: true,
                ajax: {
                    url: "{{ route('company.city.search') }}",
                    dataType: 'json',
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (source) {
                                return {
                                    id: source.id,
                                    text: source.label
                                };
                            })
                        };
                    }
                }
            });
        });
    </script>
@endsection

