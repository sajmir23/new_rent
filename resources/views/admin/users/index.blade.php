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
                        <li class="breadcrumb-item text-white fw-bold lh-1">Users</li>
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
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Users                                <!--begin::Description-->
                            <span class="page-desc text-gray-600 fw-semibold fs-6 pt-3">Users Description</span>
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
    <div class="app-container container-xxl">
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <form id="searchForm" method="get" action="#">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1 me-5">
                                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                                        <input type="text" name="general_search_input" id="general_search_input" value="{{request('general_search_input') ? : ""}}"
                                               class="form-control form-control-solid w-250px ps-13"
                                               placeholder="Search User" />
                                    </div>
                                    <!--end::Search-->
                                </form>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                    @if (auth()->user()->hasPermission('users.store'))
                                    <a  href="{{route('admin.users.create')}}"  class="btn btn-primary">
                                        <i class="ki-outline ki-plus fs-2"></i>Add User</a>
                                    @endif
                                </div>
                                <!--end::Toolbar-->

                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->

                        <div class="mt-3 p-3">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button type="button" class=" accordion-button btn btn-light-primary me-3"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"  aria-controls="collapseOne" >
                                            <i class="ki-outline ki-filter fs-2"></i>Custom Filter</button>

                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <form action="#" method="GET">

                                                <div class="row">

                                                    {{-- First name--}}
                                                    <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-semibold form-label mt-3">
                                                            <span>First Name</span>
                                                            <span class="ms-1" data-bs-toggle="tooltip"></span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid" name="first_name" value="{{request('first_name') ? : ""}}">
                                                        <!--end::Input-->
                                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                    {{-- Last name--}}
                                                    <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-semibold form-label mt-3">
                                                            <span>Last Name</span>
                                                            <span class="ms-1" data-bs-toggle="tooltip"></span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid" name="last_name" value="{{request('last_name') ? : ""}}">
                                                        <!--end::Input-->
                                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                    {{--   Email--}}
                                                    <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-semibold form-label mt-3">
                                                            <span>Email</span>
                                                         </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" value="{{request('email') ? : ""}}"
                                                               class="form-control form-control-solid" name="email">
                                                        <!--end::Input-->
                                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                    {{--   Role--}}
                                                    <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                        <label class="fs-6 fw-semibold form-label mt-3">
                                                            <span >Role</span>
                                                        </label>
                                                        <select name="role_id" id="role_id" aria-label="Select a Role"
                                                                data-control="select2" data-placeholder="Select a role..."
                                                                class="form-select form-select-solid form-select-lg fw-semibold">
                                                            @if(request('role_id'))

                                                                <option value="{{$role->id}}">{{$role->title}}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    {{--   Status--}}
                                                    <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label for="status" class="fs-6 fw-semibold form-label mt-3">
                                                            <span >Status</span>
                                                        </label>
                                                        <!--end::Label-->

                                                        <select class="form-control form-control-solid" name="status" id="status"  data-control="select2" data-placeholder="Select a status...">
                                                            <option value="3" selected>Any</option>
                                                            <option value='1' @if(request('status') == 1) selected @endif>Active</option>
                                                            <option value='2' @if(request('status') == 2) selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                    {{--   Show Nr--}}
                                                    <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-semibold form-label mt-3">
                                                            <span >Show Number</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="number" class="form-control form-control-solid" name="show_number"
                                                               value="{{request('show_number') ? : 20}}">
                                                        <!--end::Input-->
                                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                                                </div>
                                                <!--end::Col-->
                                                <strong>Click the </strong> <code>filter  </code>button to apply new filters.

                                                <div class="d-flex justify-content-start mt-3" data-kt-user-table-toolbar="base">
                                                    <button type="submit" class="btn btn-bg-secondary btn-active-success">Filter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--begin::Card body-->
                        <div class="card-body py-4">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                                <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                                        </div>
                                    </th>
                                    <th class="min-w-125px">Id</th>
                                    <th class="min-w-125px">User</th>
                                    <th class="min-w-125px">Role</th>
                                    <th class="min-w-125px">Status</th>
                                    <th class="min-w-125px">Google Login</th>
                                    <th class="min-w-125px">Last login</th>
                                    <th class="min-w-125px">Joined Date</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-semibold">
                                @foreach($users as $user)
                                    <tr id="user_row_{{$user->id}}">
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                            </div>
                                        </td>
                                        <td>#{{$user->id}}</td>
                                        <td class="d-flex align-items-center">
                                            <!--begin:: Avatar -->
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="{{route('admin.users.edit',$user->id)}}">
                                                    <div class="symbol-label fs-3 bg-light-danger text-danger">{{substr($user->first_name, 0, 1)}}</div>
                                                </a>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::User details-->
                                            <div class="d-flex flex-column">
                                                <a href="javascript:void(0)" class="text-gray-800 text-hover-primary mb-1">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}</a>
                                                <span>{{$user->email}}</span>
                                            </div>
                                            <!--begin::User details-->
                                        </td>
                                        <td>{{ucfirst($user->role->title)}}</td>

                                        <td>
                                            @if($user->status == 1)
                                                <div class="badge badge-light-success fw-bold">Active</div>

                                            @else
                                                <div class="badge badge-light-danger fw-bold">Inactive</div>
                                            @endif
                                        </td>


                                        <td>
                                            @if($user->approved_google_login == 1)
                                                <div class="badge badge-light-success fw-bold">Yes</div>

                                            @else
                                                <div class="badge badge-light-danger fw-bold">No</div>
                                            @endif
                                        </td>


                                        <td>
                                            <div class="badge badge-light fw-bold">{{\Carbon\Carbon::parse($user->last_login)->diffForHumans()}}</div>
                                        </td>

                                        <td>{{\Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i:s')}}</td>
                                        <td class="text-end">
                                            @if(auth()->user()->hasPermission('users.update'))
                                                <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    @if(auth()->user()->hasPermission('users.update'))
                                                    <div class="menu-item px-3">
                                                        <a href="{{route('admin.users.edit',$user->id)}}" class="menu-link px-3">Edit</a>
                                                    </div>
                                                    @endif
                                                    <!--end::Menu item-->
                                                    @if(auth()->user()->hasPermission('users.delete'))
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" onclick="showDeleteModal({{$user->id}})">Delete</a>
                                                    </div>
                                                    @endif

                                                    @if(auth()->user()->hasPermission('impersonation.can_impersonate'))
                                                    <div class="menu-item px-3">
                                                    @if($user->id != auth()->id())
                                                            <a href="{{ route('admin.users.impersonate',$user->id) }}" class="menu-link px-3">Impersonate</a>

                                                        @endif
                                                    </div>
                                                        @endif
                                                <!--end::Menu item-->
                                            </div>
                                            @endif
                                            <!--end::Menu-->
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $users->links() }}
                            <!--end::Table-->
                        </div>


                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Confirm Action ?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        If you click continue data can be permanently lost
                                    </div>
                                    <input type="hidden" id="hidden_delete_id">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" id="delete_button" class="btn btn-danger" onclick="confirmDeleteAction()">Continue</button>
                                    </div>
                                </div>
                            </div>
                        </div>

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

    <script>
        function showDeleteModal(data_id){
            $('#hidden_delete_id').val(data_id);
            var myModal = new bootstrap.Modal(document.getElementById('deleteModal'))
            myModal.show()
        }

        function confirmDeleteAction(){
            var delete_id   = document.getElementById('hidden_delete_id').value;
            document.getElementById("delete_button").disabled = true;
            var data = {
                delete_id: delete_id,
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                data: {
                    data: data
                },
                url: '{{route("admin.users.destroy")}}',
            }).done(function (data) {
                $('#deleteModal').modal('hide');
                document.getElementById("delete_button").disabled = false;
                if (data['status'] === 1) {
                    toastr.success(data['message'], 'Success')
                    var row = document.getElementById('user_row_'+delete_id);
                    var table = row.parentNode;
                    while ( table && table.tagName != 'TABLE' )
                        table = table.parentNode;
                    if ( !table )
                        return;
                    table.deleteRow(row.rowIndex);
                } else if (data['status'] === 2) {
                    toastr.error(data['message'], 'Error')
                } else {
                    toastr.error('Something went wrong , Please try again later')
                }
            });
        }
    </script>

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{asset('metronic/assets/js/custom/apps/user-management/users/list/table.js')}}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var searchInput = document.getElementById("general_search_input");
            var searchForm = document.getElementById("searchForm");

            searchInput.addEventListener("change", function() {
                searchForm.submit();
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $role_id  = $('#role_id');

            $role_id.select2({
                placeholder: "Role",
                allowClear: true,
                ajax: {
                    url: "{{ route('admin.roles.search') }}",
                    dataType: 'json',
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term
                        }
                    },
                    processResults: function (data) {
                        console.log(data);
                        return {
                            results: $.map(data, function (source) {
                                return {
                                    id: source.id,
                                    text: source.label,
                                }
                            })
                        }
                    }
                }
            })
        })
    </script>


    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endsection
