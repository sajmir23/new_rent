@extends('admin.layout.app')

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
                            <a href="{{route('admin.dashboard')}}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-gray-700 fs-6"></i>
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
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Roles List  <!--begin::Description-->
                            <span class="page-desc text-gray-600 fw-semibold fs-6 pt-3">Roles Description</span>
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
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">

            @if(session()->has('successMessage') ||session()->has('errorMessage') )
                <div class="card card-flush">
                    @if(session()->has('successMessage'))<div class="alert alert-success">{{ session()->get('successMessage') }}</div>@endif
                    @if(session()->has('errorMessage'))<div class="alert alert-danger">{{ session()->get('errorMessage') }}</div>@endif

                </div>
            @endif


            <!--begin::Row-->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">

                <div class="ol-md-4">
                    <!--begin::Card-->
                    <div class="card h-md-100">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center">
                            <!--begin::Button-->
                            <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                                <!--begin::Illustration-->
                                <img src="{{asset('metronic/assets/media/illustrations/sketchy-1/4.png')}}" alt="" class="mw-100 mh-150px mb-7">
                                <!--end::Illustration-->
                                <!--begin::Label-->
                                <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                                <!--end::Label-->
                            </button>
                            <!--begin::Button-->
                        </div>
                        <!--begin::Card body-->
                    </div>
                    <!--begin::Card-->
                </div>

                @foreach($roles as $role)
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <!--begin::Card-->
                            <div class="card card-flush h-md-100">

                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>{{ucfirst($role->title)}}</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-1">
                                <!--begin::Users-->
                                <div class="fw-bold text-gray-600 mb-5">  {{$role->description}}</div>
                                <div class="fw-bold text-gray-600 mb-5">Total users with this role: {{$role->users_count}}</div>
                                <!--end::Users-->
                                <!--begin::Permissions-->
                                <div class="d-flex flex-column text-gray-600">

                                    @php
                                        $permissions = $role->permissions->take(5);
                                        $remainingPermissionsCount = $role->permissions->count() - $permissions->count();
                                    @endphp


                                    @foreach ($permissions as $permission)
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>{{$permission->name}}
                                    </div>

                                    @endforeach
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>
                                        <em>and {{$remainingPermissionsCount}} more...</em>
                                    </div>
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            <div class="card-footer flex-wrap pt-0">
                                <a href="{{route('admin.roles.permissions',$role->id)}}" class="btn btn-light btn-active-primary my-1 me-2">Manage Permissions</a>
                            </div>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                @endforeach

            </div>
            <!--end::Row-->
          @include('admin.roles_permissions.modals')
        </div>
        <!--end::Content-->
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
