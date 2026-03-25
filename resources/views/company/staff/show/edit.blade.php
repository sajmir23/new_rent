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
                            <a href="{{route('company.staff.index')}}" class="text-white text-hover-primary">Staff List</a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Staff Details</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Staff Details</h1>
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
                    @include('company.staff.show.partials.navbar')

                    <!--begin::Content-->
                    <div class="row gx-6 gx-xl-9 mt-5">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <!--begin::Form-->
                                <form action="{{route('company.staff.update',$staff->id)}}" class="ajax-form"  method="post" id="staff_store_form">
                                    @csrf
                                    @method('PUT')

                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column align-items-start flex-xxl-row">
                                        <!--begin::ref number-->
                                        <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                            <span class="fs-2x fw-bold text-gray-800">Update Staff #</span>
                                        </div>
                                        <!--end::ref number-->
                                    </div>
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed my-10"></div>
                                    <!--end::Separator-->

                                    <!--begin::Wrapper-->
                                    <div class="mb-0">
                                        <div class="row gx-10 mb-5">
                                            <!--begin::Col-->
                                            <div class="col-lg-6 mt-4">
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <div>
                                                        <label for="first_name" class="col-lg-4 col-form-label fw-semibold fs-6 required">
                                                            <span>First Name</span> </label>
                                                    </div>
                                                    <div class="col-lg-10 fv-row">
                                                        <input type="search" name="first_name" id="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               value="{{ old('first_name', $staff->first_name) }}" placeholder="First Name"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <div>
                                                        <label for="last_name" class="col-lg-4 col-form-label fw-semibold fs-6 required">
                                                            <span>Last Name</span> </label>
                                                    </div>
                                                    <div class="col-lg-10 fv-row">
                                                        <input type="search" name="last_name" id="last_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               value="{{ old('last_name', $staff->last_name) }}" placeholder="Last Name"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <div>
                                                        <label for="brand_id" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Company</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-10 fv-row">
                                                        <select name="company_id" id="company_id"
                                                                aria-label="Select a Company"
                                                                data-control="select2"
                                                                data-placeholder="Select a Company..."
                                                                class="form-select form-select-solid form-select-lg fw-semibold">
                                                            <option value="{{ old('company_id', $staff->company_id ?? '') }}" selected hidden>
                                                                {{ old('name', $staff->company->name ?? 'Select Company') }}
                                                            </option>
                                                        </select>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <div>
                                                        <label for="phone_number" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Phone</span> </label>
                                                    </div>
                                                    <div class="col-lg-10 fv-row">
                                                        <input type="search" name="phone_number" id="phone_number" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               value="{{ old('phone_number', $staff->phone_number) }}" placeholder="Phone"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Separator-->
                                                <div class="separator separator-dashed mb-8"></div>
                                                <!--end::Separator-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-lg-6 mt-4">
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <div>
                                                        <label for="password" class="col-lg-4 col-form-label fw-semibold fs-6 required">
                                                            <span>Password</span>
                                                        </label>
                                                    </div>
                                                    <!-- Input -->
                                                    <div class="col-lg-10 fv-row">
                                                        <input type="search" name="password" id="password"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Password">
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Col-->
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <div>
                                                        <label for="password_confirmation" class="col-lg-4 col-form-label fw-semibold fs-6 required">
                                                            <span>Password Confirmation</span>
                                                        </label>
                                                    </div>
                                                    <!-- Input -->
                                                    <div class="col-lg-10 fv-row">
                                                        <input type="search" name="password_confirmation" id="password_confirmation"
                                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               placeholder="Password Confirmation">
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <div>
                                                        <label for="email" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Email</span> </label>
                                                    </div>
                                                    <div class="col-lg-10 fv-row">
                                                        <input type="search" name="email" id="email" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               value="{{ old('email', $staff->email) }}" placeholder="Email"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <div>
                                                        <label for="address" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span>Address</span> </label>
                                                    </div>
                                                    <div class="col-lg-10 fv-row">
                                                        <input type="search" name="address" id="address" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                               value="{{ old('address', $staff->address ?? '') }}" placeholder="Address"/>
                                                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                    </div>
                                                </div>
                                                <!--end::Input group-->
                                                <div class="mb-8 mt-7">
                                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-5">
                                                          <span class="form-check-label ms-0 fw-bold fs-6 text-gray-700">Status</span>
                                                        <input class="form-check-input" @if($staff->status == true) checked @endif type="checkbox" name="status">
                                                    </label>
                                                </div>
                                                <!--begin::Separator-->
                                                <div class="separator separator-dashed mb-8"></div>
                                                <!--end::Separator-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <div>
                                                    <label for="notes" class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Notes</span> </label>
                                                </div>
                                                <div class="col-lg-12 fv-row">
                                                           <textarea name="notes" id="notes" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                     placeholder="Notes">{{ old('notes', $staff->notes) }} </textarea>
                                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                                </div>
                                            </div>
                                            <!--end::Input group-->
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
    <script>
        $(document).ready(function () {
            var $company_id = $('#company_id');
            $company_id.select2({
                placeholder: "User",
                allowClear: true,
                ajax: {
                    url: "{{ route('company.staff.search') }}",
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
