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
                        <li class="breadcrumb-item text-white fw-bold lh-1">Permissions</li>
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
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Permission List                         <!--begin::Description-->
                            <span class="page-desc text-gray-600 fw-semibold fs-6 pt-3">Full List Roles</span>
                            <!--end::Description--></h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Stats-->
                    <div class="d-flex align-self-center flex-center flex-shrink-0">
                        <a href="#" class="btn btn-flex btn-sm btn-outline btn-active-color-primary btn-custom px-4" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                            <i class="ki-outline ki-plus-square fs-4 me-2"></i>Invite</a>
                        <a href="#" class="btn btn-sm btn-active-color-primary btn-outline btn-custom ms-3 px-4" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Set Your Target</a>
                    </div>
                    <!--end::Stats-->
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
    <!--begin::Wrapper container-->
    <div class="app-container container-xxl">
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Card-->
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <form id="searchForm" method="get" action="#">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1 me-5">
                                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                                        <input type="text" name="general_search_input" id="general_search_input" value="{{request('general_search_input') ? : ""}}"
                                               class="form-control form-control-solid w-250px ps-13"
                                               placeholder="Search Permissions" />
                                    </div>
                                    <!--end::Search-->
                                </form>

                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Button-->
                                <a href="{{ route('admin.permissions.create') }}" class="btn btn-light-primary">
                                    <i class="ki-outline ki-plus-square fs-3"></i>Add Permission</a>
                                <!--end::Button-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                                <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Permission Group</th>
                                    <th class="min-w-125px">Permission</th>
                                    <th class="min-w-250px">Assigned To</th>
                                    <th class="min-w-125px">Created Date</th>
                                    <th class="min-w-125px">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                @foreach($groupedData as $key=>$permissions)
                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{ucfirst($key)}}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="fs-7 m-1">{{ucfirst($permission->name)}}</a>
                                            </td>

                                            <td>
                                                @foreach($permission->roles as $role)
                                                    <a href="{{route('admin.roles.permissions',$role->id)}}" style="background-color: {{$role->background_color ? : "green"}}; color: {{$role->text_color ? : "white"}}" class="badge fs-7 m-1">{{ucfirst($role->title)}}</a>
                                                @endforeach

                                            </td>
                                            <td>{{\Carbon\Carbon::parse($permission->created_at)->format('d-m-Y H:i:s')}}</td>

                                            <td class="text-end">
                                                <a href="{{route('admin.permissions.users',$permission->id)}}" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" >
                                                    <i class="ki-outline ki-setting-3 fs-3"></i>
                                                </a>
                                            </td>
                                        </tr>

                                    @endforeach
                                @endforeach

                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
        </div>
        <!--end:::Main-->
    </div>
    <!--end::Wrapper container-->
@endsection

@section('custom-js')

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{asset('metronic/assets/js/custom/apps/user-management/permissions/list.js')}}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var searchInput = document.getElementById("general_search_input");
            var searchForm = document.getElementById("searchForm");

            searchInput.addEventListener("change", function() {
                searchForm.submit();
            });
        });
    </script>


    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endsection
