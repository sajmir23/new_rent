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
                            <span class="page-desc text-gray-600 fw-semibold fs-6 pt-3">Edit System User</span>
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
    <!--begin::Wrapper container-->
    <div class="app-container container-xxl">
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">


                    @if(session()->has('successMessage') ||session()->has('errorMessage') )
                        <div class="card card-flush">
                            @if(session()->has('successMessage'))<div class="alert alert-success">{{ session()->get('successMessage') }}</div>@endif
                            @if(session()->has('errorMessage'))<div class="alert alert-danger">{{ session()->get('errorMessage') }}</div>@endif

                        </div>
                    @endif

                    <!--begin::Contacts App- Add New Contact-->
                    <div class="row g-7">
                        <!--begin::Contact groups-->
                        <div class="col-lg-6 col-xl-4">
                            <!--begin::Contact group wrapper-->
                            <div class="card card-flush">
                                <!--begin::Card header-->
                                <div class="card-header pt-7" id="kt_chat_contacts_header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Roles</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-5">
                                    <!--begin::Contact groups-->
                                    <div class="d-flex flex-column gap-5">
                                        @foreach($roles as $role)
                                            <!--begin::Contact group-->
                                            <div class="d-flex flex-stack">
                                                <a href="{{route('admin.roles.permissions',$role->id)}}"
                                                   class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary active">{{$role->title}}</a>
                                                <div class="badge badge-light-primary">{{$role->users_count}}</div>
                                            </div>
                                            <!--begin::Contact group-->
                                        @endforeach


                                    </div>
                                    <!--end::Contact groups-->
                                    <!--begin::Separator-->
                                    <div class="separator my-7"></div>


                                    <!--begin::Separator-->
                                    <!--begin::Add new contact-->
                                    <a href="{{route('admin.roles.index')}}" class="btn btn-primary w-100">
                                        <i class="ki-outline ki-badge fs-2"></i>Manage Roles</a>
                                    <!--end::Add new contact-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Contact group wrapper-->
                        </div>
                        <!--end::Contact groups-->

                        <!--begin::Content-->
                        <div class="col-xl-8">
                            <!--begin::Contacts-->
                            <div class="card card-flush h-lg-100" id="kt_contacts_main">
                                <!--begin::Card header-->
                                <div class="card-header pt-7" id="kt_chat_contacts_header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <i class="ki-outline ki-badge fs-1 me-2"></i>
                                        <h2>Update System User ({{$user->fullName()}})</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-5">
                                    <!--begin::Form-->
                                    <form id="store_users_form" class="form" method="POST" action="{{route('admin.users.update',$user->id)}}">
                                        @csrf
                                        {{method_field('PUT')}}

                                        <!--begin::Input Image group-->
                                        <div class="mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-3">
                                                <span>Update Avatar</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Allowed file types: png, jpg, jpeg.">
																	<i class="ki-outline ki-information fs-7"></i>
																</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Image input wrapper-->
                                            <div class="mt-1">
                                                <!--begin::Image placeholder-->
                                                <style>.image-input-placeholder { background-image: url('{{asset('metronic/assets/media/svg/files/blank-image.svg')}}'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('{{asset('metronic/assets/media/svg/files/blank-image-dark.svg')}}'); }</style>
                                                <!--end::Image placeholder-->
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-outline image-input-placeholder image-input-empty image-input-empty" data-kt-image-input="true">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-100px h-100px" style="background-image: url('')"></div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Edit-->
                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                        <i class="ki-outline ki-pencil fs-7"></i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="avatar_remove" />
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Edit-->
                                                    <!--begin::Cancel-->
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																		<i class="ki-outline ki-cross fs-2"></i>
													</span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																		<i class="ki-outline ki-cross fs-2"></i>
																	</span>
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                            </div>
                                            <!--end::Image input wrapper-->
                                        </div>
                                        <!--end::Input group-->



                                        <!--begin::Input First name group-->
                                        <div class="fv-row mb-7">

                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span class="required">First Name</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Enter the system user's name.">
													<i class="ki-outline ki-information fs-7"></i>
												</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid
                                                   @if($errors->first('name')) border-danger @endif "
                                                   name="name" value="{{old('name',$user->first_name)}}"
                                            />

                                            @if($errors->first('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::Input Last name group-->
                                        <div class="fv-row mb-7">

                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span class="required">Last Name</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Enter the system user's last name.">
													<i class="ki-outline ki-information fs-7"></i>
												</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid
                                                   @if($errors->first('last_name')) border-danger @endif "
                                                   name="last_name" value="{{old('last_name',$user->last_name)}}"
                                            />

                                            @if($errors->first('last_name'))
                                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::Input Email group-->
                                        <div class="fv-row mb-7">

                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span class="required">Email</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Enter the system user's email.">
													<i class="ki-outline ki-information fs-7"></i>
												</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="email" class="form-control form-control-solid
                                                   @if($errors->first('email')) border-danger @endif "
                                                   name="email" value="{{old('email',$user->email)}}"
                                            />

                                            @if($errors->first('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Row-->
                                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                                            <!--begin:: Role Col-->
                                            <div class="col">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span class="required">Role</span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Select user's role.">
														<i class="ki-outline ki-information fs-7"></i>
														</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select name="role_id" id="role_id" aria-label="Select a Role"
                                                            data-control="select2" data-placeholder="Select a role..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold @if($errors->first('role_id')) border-danger @endif ">

                                                        @foreach($roles as $role)
                                                            <option value="{{$role->id}}"
                                                                    @if(old('role_id',$user->role_id) == $role->id) selected @endif
                                                            >{{$role->title}}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    <!--end::Input-->
                                                    @if($errors->first('role_id'))
                                                        <span class="text-danger">{{ $errors->first('role_id') }}</span>
                                                    @endif

                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Phone Col-->
                                            <div class="col">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Phone</span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Enter the system user's phone.">
													<i class="ki-outline ki-information fs-7"></i>
												</span>
                                                    </label>
                                                    <!--end::Label-->

                                                    <!--begin::Input-->
                                                    <input type="text" class="form-control form-control-solid
                                                   @if($errors->first('phone')) border-danger @endif "
                                                           name="phone" value="{{old('phone',$user->phone_number)}}"
                                                    />

                                                    @if($errors->first('phone'))
                                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                    @endif
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                                            <!--begin:: Role Col-->
                                            <div class="col">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span class="required">Status</span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Select user's status.">
														<i class="ki-outline ki-information fs-7"></i>
														</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select name="status" id="status" aria-label="Select a Status"
                                                            data-control="select2" data-placeholder="Select a status..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold
                                                            @if($errors->first('status')) border-danger @endif ">

                                                        <option value="1" selected >Active</option>
                                                        <option value="2" @if(old('status',$user->status) != 1) selected @endif>Inactive</option>

                                                    </select>
                                                    <!--end::Input-->
                                                    @if($errors->first('status'))
                                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                                    @endif

                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin:: Role Col-->
                                            <div class="col">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span class="required">Google Login</span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Select user's status.">
														<i class="ki-outline ki-information fs-7"></i>
														</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select name="approved_google_login" id="approved_google_login" aria-label="Select "
                                                            data-control="select2" data-placeholder="Select ..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold
                                                            @if($errors->first('approved_google_login')) border-danger @endif ">

                                                        <option value="2" selected >No</option>
                                                        <option value="1" @if(old('approved_google_login',$user->approved_google_login) == 1) selected @endif>Yes</option>

                                                    </select>
                                                    <!--end::Input-->
                                                    @if($errors->first('approved_google_login'))
                                                        <span class="text-danger">{{ $errors->first('approved_google_login') }}</span>
                                                    @endif

                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">

                                            <!--begin::Phone Col-->
                                            <div class="col">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Address</span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Enter the system user's address.">
													<i class="ki-outline ki-information fs-7"></i>
												</span>
                                                    </label>
                                                    <!--end::Label-->

                                                    <!--begin::Input-->
                                                    <input type="text" class="form-control form-control-solid
                                                   @if($errors->first('address')) border-danger @endif "
                                                           name="address" value="{{old('address',$user->address)}}"
                                                    />
                                                    @if($errors->first('address'))
                                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                                    @endif
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Pass Col-->
                                            <div class="col">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span class="required">Password</span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Enter the system user's password.">
													<i class="ki-outline ki-information fs-7"></i>
												</span>
                                                    </label>
                                                    <!--end::Label-->

                                                    <!--begin::Input-->
                                                    <input type="password" class="form-control form-control-solid
                                                   @if($errors->first('password')) border-danger @endif "
                                                           name="password" value="{{old('password')}}"
                                                    />
                                                    @if($errors->first('password'))
                                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Pass Col-->
{{--                                            <div class="col">--}}
{{--                                                <!--begin::Input group-->--}}
{{--                                                <div class="fv-row mb-7">--}}
{{--                                                    <!--begin::Label-->--}}
{{--                                                    <label class="fs-6 fw-semibold form-label mt-3">--}}
{{--                                                        <span class="required">Password Confirmation</span>--}}
{{--                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Repeat the system user's password.">--}}
{{--													<i class="ki-outline ki-information fs-7"></i>--}}
{{--												</span>--}}
{{--                                                    </label>--}}
{{--                                                    <!--end::Label-->--}}

{{--                                                    <!--begin::Input-->--}}
{{--                                                    <input type="password" class="form-control form-control-solid--}}
{{--                                                   @if($errors->first('password')) border-danger @endif "--}}
{{--                                                           name="password_confirmation" value="{{old('password')}}"--}}
{{--                                                    />--}}
{{--                                                    @if($errors->first('password_confirmation'))--}}
{{--                                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>--}}
{{--                                                    @endif--}}
{{--                                                    <!--end::Input-->--}}
{{--                                                </div>--}}
{{--                                                <!--end::Input group-->--}}
{{--                                            </div>--}}
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>Notes</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Enter any additional notes about the contact (optional).">
												<i class="ki-outline ki-information fs-7"></i>
												</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control form-control-solid  @if($errors->first('notes')) border-danger @endif "
                                                      name="notes">{{old('notes',$user->notes)}}</textarea>
                                            <!--end::Input-->
                                            @if($errors->first('notes'))
                                                <span class="text-danger">{{ $errors->first('notes') }}</span>
                                            @endif

                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Separator-->
                                        <div class="separator mb-6"></div>
                                        <!--end::Separator-->
                                        <!--begin::Action buttons-->
                                        <div class="d-flex justify-content-end">
                                            <!--begin::Button-->
                                            <button type="reset" data-kt-contacts-type="cancel" class="btn btn-light me-3">Cancel</button>
                                            <!--end::Button-->
                                            <!--begin::Button-->
                                            <button type="submit" data-kt-contacts-type="submit" class="btn btn-primary">
                                                <span class="indicator-label">Update</span>
                                                <span class="indicator-progress">Please wait...
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                            <!--end::Button-->
                                        </div>
                                        <!--end::Action buttons-->

                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Contacts-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Contacts App- Add New Contact-->
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
    <script src="{{asset('metronic/assets/js/custom/apps/user-management/users/list/table.js')}}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endsection
