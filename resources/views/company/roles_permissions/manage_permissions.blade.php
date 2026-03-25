@extends('company.layout.app')

@section('custom-css')

    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->

@endsection

@section('toolbar')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
            <!--begin::Toolbar container-->
            <div class="d-flex flex-column flex-row-fluid">
                <!--begin::Toolbar wrapper-->
                <div class="d-flex align-items-center pt-1">
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{route('company.dashboard')}}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-white fs-6"></i>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-white fw-bold lh-1">Roles</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Toolbar wrapper=-->
                <!--begin::Toolbar wrapper=-->
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <!--begin::Page title-->
                    <div class="page-title me-5">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Role List                               <!--begin::Description-->
                            <span class="page-desc text-gray-600 fw-semibold fs-6 pt-3">Role Description</span>
                            <!--end::Description--></h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->

                </div>
                <!--end::Toolbar wrapper=-->
            </div>
            <!--end::Toolbar container=-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
@endsection
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Products-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                            <div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive">
                                    @if(session()->has('successMessage'))<div class="alert alert-success">{{ session()->get('successMessage') }}</div>@endif
                                    @if(session()->has('errorMessage'))<div class="alert alert-danger">{{ session()->get('errorMessage') }}</div>@endif
                                    <div class="modal-body scroll-y mx-lg-5 my-7">
                                        <!--begin::Form-->
                                        <form id="kt_modal_add_role_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                              method="POST" action="{{route('company.roles.update',$role->id)}}">
                                            @method('PUT')
                                            @csrf
                                            <!--begin::Scroll-->
                                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px" style="">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-10 fv-plugins-icon-container">
                                                    <!--begin::Label-->
                                                    <label class="fs-5 fw-bold form-label mb-2">
                                                        <span class="required">Role name</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid"
                                                           required placeholder="Enter a role name"
                                                           value="{{old('role_name',$role->title)}}"
                                                           name="role_name">
                                                    <!--end::Input-->

                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="fv-row mb-10 fv-plugins-icon-container">
                                                    <!--begin::Label-->
                                                    <label class="fs-5 fw-bold form-label mb-2">
                                                        <span class="required">Role Description</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" value="{{old('role_description',$role->description)}}" required placeholder="Role Description" name="role_description">
                                                    <!--end::Input-->

                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="fv-row mb-10 fv-plugins-icon-container">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <!--begin::Label-->
                                                            <label class="fs-5 fw-bold form-label mb-2">
                                                                <span class="required">Background Color</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="color" class="form-control form-control-solid"
                                                                   required placeholder="Background Color"
                                                                   value="{{old('background_color',$role->background_color)}}"
                                                                   name="background_color">
                                                            <!--end::Input-->

                                                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-6">
                                                            <!--begin::Label-->
                                                            <label class="fs-5 fw-bold form-label mb-2">
                                                                <span class="required">Text Color</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="color"
                                                                   value="{{old('text_color',$role->text_color)}}"
                                                                   class="form-control form-control-solid" required placeholder="Text Color" name="text_color">
                                                            <!--end::Input-->

                                                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Permissions-->
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                                                    <!--end::Label-->
                                                    <!--begin::Table wrapper-->
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                            <!--begin::Table body-->
                                                            <tbody class="text-gray-600 fw-semibold">
                                                            <!--begin::Table row-->
                                                            <tr>
                                                                <td class="text-gray-800">Full Access
                                                                    <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Allows a full access to the system" data-kt-initialized="1">
												<i class="ki-outline ki-information fs-7"></i>
											</span></td>
                                                                <td>
                                                                    <!--begin::Checkbox-->
                                                                    <label class="form-check form-check-custom form-check-solid me-9">
                                                                        <input class="form-check-input" type="checkbox" value="" id="check_all_check">
                                                                        <span class="form-check-label">Select all</span>
                                                                    </label>
                                                                    <!--end::Checkbox-->
                                                                </td>
                                                            </tr>
                                                            <!--end::Table row-->

                                                            @foreach($groupedPermissions as $key=>$group)
                                                                <!--begin::Table row-->
                                                                <tr>
                                                                    <!--begin::Label-->
                                                                    <td class="text-gray-800">{{ucfirst($key)}}</td>
                                                                    <!--end::Label-->
                                                                    <!--begin::Options-->
                                                                    <td>
                                                                        <!--begin::Wrapper-->
                                                                        <div class="d-flex">
                                                                            @foreach($group as $permission)
                                                                                <!--begin::Checkbox-->
                                                                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                                    <input class="form-check-input"

                                                                                           @if(in_array($permission->id,$role_permissions))  checked @endif
                                                                                           type="checkbox" value="{{$permission->id}}" name="new_role_permissions[]">
                                                                                    <span class="form-check-label">{{ucfirst($permission->name)}}</span>
                                                                                </label>
                                                                                <!--end::Checkbox-->
                                                                            @endforeach
                                                                        </div>
                                                                        <!--end::Wrapper-->
                                                                    </td>
                                                                    <!--end::Options-->
                                                                </tr>
                                                                <!--end::Table row-->
                                                            @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->
                                                    </div>
                                                    <!--end::Table wrapper-->
                                                </div>
                                                <!--end::Permissions-->
                                            </div>
                                            <!--end::Scroll-->
                                            <!--begin::Actions-->
                                            <div class="text-center pt-15">
                                                <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button>
                                                <button id="submitBtn" type="submit" class="btn btn-primary">
                                                    <span class="indicator-label">Update</span>
                                                    <span class="indicator-progress d-none">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                                                </button>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end::Form-->
                                    </div>
                            </div>

                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Products-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

    </div>
@endsection

@section('custom-js')

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{asset('metronic/assets/js/custom/apps/user-management/roles/list/add.js')}}"></script>
    <script src="{{asset('metronic/assets/js/custom/apps/user-management/roles/list/update-role.js')}}"></script>
    <script src="{{asset('metronic/assets/js/widgets.bundle.js')}}"></script>
    <script src="{{asset('metronic/assets/js/custom/widgets.js')}}"></script>
    <script src="{{asset('metronic/assets/js/custom/apps/chat/chat.js')}}"></script>
    <script src="{{asset('metronic/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
    <script src="{{asset('metronic/assets/js/custom/utilities/modals/new-target.js')}}"></script>
    <script src="{{asset('metronic/assets/js/custom/utilities/modals/users-search.js')}}"></script>
    <!--end::Custom Javascript-->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.addEventListener('click', function (event) {
                // Prevent multiple clicks
                if (submitBtn.classList.contains('disabled')) {
                    event.preventDefault();
                    return;
                }

                // Show "Please wait..." message
                submitBtn.querySelector('.indicator-label').classList.add('d-none');
                submitBtn.querySelector('.indicator-progress').classList.remove('d-none');

                // Disable the button to prevent multiple clicks
                submitBtn.classList.add('disabled');

                // Optional: You can submit the form here
                // Example: document.getElementById('myForm').submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Add click event listener to the main checkbox
            $('#check_all_check').click(function() {
                // Check if the main checkbox is checked
                var isChecked = $(this).prop('checked');

                // Set the checked property of all checkboxes with the specified name attribute
                $('input[name="new_role_permissions[]"]').prop('checked', isChecked);
            });
        });
    </script>


@endsection
