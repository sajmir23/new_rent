{{--<!DOCTYPE html>

<html lang="en">
@include('admin.layout.head')
<!--begin::Body-->
<body id="kt_body" class="app-blank">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <!--begin::Form-->
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px p-10">
                    <!--begin::Form-->
                    <form class="form w-100" method="POST" action="{{ route('login') }}">
                        @csrf
                        <!--begin::Heading.-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
                            <!--end::Title-->
                            <!--begin::Subtitle-->
                            <div class="text-gray-500 fw-semibold fs-6">Rental Management Portal</div>
                            <!--end::Subtitle=-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Login options-->
                        <div class="row g-3 mb-9">
                            <!--begin::Col-->
                            <div class="col-md-12">
                                <!--begin::Google link=-->
                                <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo" src="{{asset('metronic/assets/media/svg/brand-logos/google-icon.svg')}}" class="h-15px me-3" />Sign in with Google</a>
                                <!--end::Google link=-->
                            </div>
                            <!--end::Col-->

                        </div>
                        <!--end::Login options-->
                        <!--begin::Separator-->
                        <div class="separator separator-content my-14">
                            <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
                        </div>
                        <!--end::Separator-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text"
                                   @if($errors->first('email')) style="border-color: red !important;" @endif
                                   value="{{old('email')}}"
                                   placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                            <!--end::Email-->
                        </div>
                        <!--end::Input group=-->
                        --}}{{--<div class="fv-row mb-3">
                            <!--begin::Password-->
                            <input type="password" @if($errors->first('password')) style="border-color: red !important;" @endif
                            placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
                            <!--end::Password-->
                        </div>--}}{{--

                        <div class="fv-row mb-3 position-relative">
                            <input type="password"
                                   id="password"
                                   @if($errors->first('password')) style="border-color: red !important;" @endif
                                   placeholder="Password"
                                   name="password"
                                   autocomplete="off"
                                   class="form-control bg-transparent pe-10" />
                                  <span onclick="togglePassword()"
                                  class="btn btn-sm btn-icon position-absolute translate-middle-y top-50 end-0 me-2">
                                  <i class="ki-outline ki-eye fs-2"></i>
                                </span>
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div></div>
                            <!--begin::Link-->
                            <a href="{{route('password.request')}}" class="link-primary">Forgot Password ?</a>
                            <!--end::Link-->
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger mt-4" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session()->has('errorMessage'))<div class="alert alert-danger">{{ session()->get('errorMessage') }}</div>@endif


                        <!--end::Wrapper-->
                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Sign In</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Submit button-->
                        <!--begin::Sign up-->
                        <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
                            <a href="{{route('register')}}" class="link-primary">Sign up</a></div>
                        <!--end::Sign up-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Form-->
            <!--begin::Footer-->
            <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">
                <!--begin::Languages-->
                <div class="me-10">
                    <!--begin::Toggle-->
                    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                        <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{asset('metronic/assets/media/flags/united-states.svg')}}" alt="" />
                        <span data-kt-element="current-lang-name" class="me-1">English</span>
                    </button>
                    <!--end::Toggle-->
                </div>
                <!--end::Languages-->
                <!--begin::Links-->
                <div class="d-flex fw-semibold text-primary fs-base gap-5">
                    <a href="#" target="_blank">Home</a>
                    <a href="#" target="_blank">About Us</a>
                    <a href="#" target="_blank">Contact Us</a>
                </div>
                <!--end::Links-->
            </div>
            <!--end::Footer-->

        </div>
        <!--end::Body-->
        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{asset('carss.jpg')}})">
            <!--begin::Content-->

            <!--end::Content-->
        </div>
        <!--end::Aside-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('metronic/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('metronic/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('metronic/assets/js/custom/authentication/sign-in/general.js')}}"></script>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>--}}

        <!DOCTYPE html>
<html lang="en">
@include('admin.layout.head')

<body id="kt_body" class="app-blank">

<script>
    var defaultThemeMode = "light";
    var themeMode;

    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }

        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }

        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>

<div class="d-flex flex-column flex-root" id="kt_app_root">

    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <!-- LEFT SIDE -->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1"
             style="
background: linear-gradient(135deg,#f8fafc,#eef2f7);
border-right:1px solid rgba(0,0,0,0.05);
">

            <div class="d-flex flex-center flex-column flex-lg-row-fluid">

                <div class="w-lg-500px p-10 bg-white rounded-4 shadow-sm">

                    <form class="form w-100" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="text-center mb-11">

                            <h1 class="text-gray-900 fw-bolder mb-3">
                                Welcome Back
                            </h1>

                            <div class="text-gray-500 fw-semibold fs-6">
                                Car Rental Management System
                            </div>

                        </div>

                        <div class="row g-3 mb-9">

                            <div class="col-md-12">

                                <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">

                                    <img alt="Logo"
                                         src="{{asset('metronic/assets/media/svg/brand-logos/google-icon.svg')}}"
                                         class="h-15px me-3" />

                                    Sign in with Google

                                </a>

                            </div>

                        </div>

                        <div class="separator separator-content my-14">

<span class="w-125px text-gray-500 fw-semibold fs-7">
Or with email
</span>

                        </div>

                        <div class="fv-row mb-8">

                            <input type="text"
                                   @if($errors->first('email')) style="border-color:red !important;" @endif
                                   value="{{old('email')}}"
                                   placeholder="Email"
                                   name="email"
                                   autocomplete="off"
                                   class="form-control bg-transparent"/>

                        </div>

                        <div class="fv-row mb-3 position-relative">

                            <input type="password"
                                   id="password"
                                   @if($errors->first('password')) style="border-color:red !important;" @endif
                                   placeholder="Password"
                                   name="password"
                                   autocomplete="off"
                                   class="form-control bg-transparent pe-10"/>

                            <span onclick="togglePassword()"
                                  class="btn btn-sm btn-icon position-absolute translate-middle-y top-50 end-0 me-2">

<i class="ki-outline ki-eye fs-2"></i>

</span>

                        </div>

                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">

                            <div></div>

                            <a href="{{route('password.request')}}" class="link-primary">
                                Forgot Password ?
                            </a>

                        </div>

                        @if ($errors->any())

                            <div class="alert alert-danger mt-4">

                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>

                            </div>

                        @endif

                        @if(session()->has('errorMessage'))
                            <div class="alert alert-danger">
                                {{ session()->get('errorMessage') }}
                            </div>
                        @endif

                        <div class="d-grid mb-10">

                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">

<span class="indicator-label">
Sign In
</span>

                                <span class="indicator-progress">
Please wait...
<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>

                            </button>

                        </div>

                        <div class="text-gray-500 text-center fw-semibold fs-6">

                            Don't have an account?

                            <a href="{{route('register')}}" class="link-primary">
                                Sign up
                            </a>

                        </div>

                    </form>

                </div>

            </div>

            <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">

                <div class="me-10">

                    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
                            data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-start">

                        <img class="w-20px h-20px rounded me-3"
                             src="{{asset('metronic/assets/media/flags/united-states.svg')}}"/>

                        <span class="me-1">English</span>

                    </button>

                </div>

                <div class="d-flex fw-semibold text-primary fs-base gap-5">

                    <a href="#">Home</a>
                    <a href="#">About Us</a>
                    <a href="#">Contact Us</a>

                </div>

            </div>

        </div>

        <!-- RIGHT SIDE IMAGE -->

        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
             style="background-image:url({{asset('carss.jpg')}})">

            <div class="d-flex flex-column flex-center w-100 h-100"
                 style="background:rgba(0,0,0,0.25)">

                <h1 class="text-white fw-bold fs-2qx text-center">

                    Smart Car Rental Platform

                </h1>

                <p class="text-white text-center mt-4 fs-6">

                    Manage vehicles, reservations and customers
                    <br>
                    from one powerful dashboard.

                </p>

            </div>

        </div>

    </div>

</div>

<script>var hostUrl = "assets/";</script>

<script src="{{asset('metronic/assets/plugins/global/plugins.bundle.js')}}"></script>

<script src="{{asset('metronic/assets/js/scripts.bundle.js')}}"></script>

<script src="{{asset('metronic/assets/js/custom/authentication/sign-in/general.js')}}"></script>

<script>

    function togglePassword() {

        const input = document.getElementById('password');

        input.type = input.type === 'password' ? 'text' : 'password';

    }

</script>

</body>
</html>
