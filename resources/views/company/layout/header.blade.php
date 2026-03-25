<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}"
     data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
    <!--begin::Header container-->
    <div class="app-container container-xxl d-flex align-items-stretch justify-content-between"
         id="kt_app_header_container">
        <!--begin::Header mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
        </div>
        <!--end::Header mobile toggle-->
        <!--begin::Logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-18">
            <a href="{{ route('company.dashboard') }}">
                <img alt="Logo" src="{{ asset('metronic/assets/media/logos/demo34-small.svg') }}"
                     class="h-25px d-sm-none"/>
                <img alt="Logo" src="{{ asset('metronic/assets/media/logos/demo34.png') }}"
                     class="h-25px d-none d-sm-block"/>
            </a>
        </div>
        <!--end::Logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                 data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                 data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
                 data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                 data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                 data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->
                <div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                     id="kt_app_header_menu" data-kt-menu="true">
                    <!--begin:Menu item-->
                    @include('company.layout.header_partials.dashboards')
                    <!--end:Menu item-->
                    @include('company.layout.header_partials.company_details')
                    <!--begin:Menu item-->
                    @include('company.layout.header_partials.rental_operations')
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    @include('company.layout.header_partials.reference_data')
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    @include('company.layout.header_partials.management')
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    @include('company.layout.header_partials.settings')

                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::Notifications-->
                @php
                    $unreadNotifications = auth()->user()->unreadNotifications;
                    $count = $unreadNotifications->count();
                @endphp

                <div class="app-navbar-item ms-1 ms-lg-5">
                    <!--begin::Menu wrapper-->
                    <div class="btn btn-icon btn-custom btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative"
                         data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                         data-kt-menu-placement="bottom-end">

                        <!-- Notification Bell -->
                        <i class="ki-outline ki-notification-on fs-1"></i>

                        @if($count > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge badge-circle bg-danger fs-8">
                             {{ $count }}
                           </span>
                        @endif
                    </div>

                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">

                        <!--begin::Heading-->
                        <div class="d-flex flex-column bgi-no-repeat rounded-top"
                             style="background-image:url('{{ asset('metronic/assets/media/misc/menu-header-bg.jpg') }}')">
                            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
                                Notifications
                                <span class="fs-8 opacity-75 ps-3">{{ $count }} new</span>
                            </h3>
                        </div>
                        <!--end::Heading-->

                        <!--begin::Items-->
                        <div class="scroll-y mh-325px my-5 px-8">
                            @forelse($unreadNotifications as $notification)
                                <div class="d-flex flex-stack py-4 notification-item" id="notif-{{ $notification->id }}">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center">
                                        <!-- Symbol (optional icon, customize per notification type if you have it) -->
                                        <div class="symbol symbol-35px me-4">
                            <span class="symbol-label bg-light-primary">
                                <i class="ki-outline ki-abstract-28 fs-2 text-primary"></i>
                            </span>
                                        </div>
                                        <!-- Title + message -->
                                        <div class="mb-0 me-2">
                                            <div class="fs-6 text-gray-800 fw-bold">
                                                {{ $notification->data['message'] ?? 'Notification' }}
                                            </div>
                                            <div class="text-gray-500 fs-7">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Section-->

                                    <!-- Dismiss -->
                                    <div class="notification-item" id="notification-{{$notification->id}}">
                                        <button class="btn btn-sm btn-icon btn-light-danger dismiss-btn"
                                                data-id="{{ $notification->id }}">
                                            <i class="bi bi-x fs-5"></i>
                                        </button>
                                    </div>

                                </div>
                            @empty
                                <div class="text-center text-muted py-10">No new notifications</div>
                            @endforelse
                        </div>
                        <!--end::Items-->

                        <!--begin::View more-->
                        <div class="py-3 text-center border-top">
                            <a href="{{route('company.notifications.index')}}"
                               class="btn btn-color-gray-600 btn-active-color-primary">View All
                                <i class="ki-outline ki-arrow-right fs-5"></i></a>
                        </div>
                        <!--end::View more-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Notifications-->

                <!--begin::User menu-->
                <div class="app-navbar-item ms-5" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img class="symbol symbol-circle symbol-35px symbol-md-40px" src="{{asset('metronic/assets/media/avatars/blank.png')}}" alt="user" />
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{asset('metronic/assets/media/avatars/blank.png')}}" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">{{auth()->user()->fullName()}}
                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{auth()->user()->role->title}}</span></div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{auth()->user()->email}}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
{{--                        <div class="menu-item px-5">--}}
{{--                            <a href="{{route('company.account')}}" class="menu-link px-5">My Profile</a>--}}
{{--                        </div>--}}
                        <!--end::Menu item-->

                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                            <a href="#" class="menu-link px-5">
                                <span class="menu-title position-relative">Mode
                                    <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                        <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                        <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                                    </span>
                                </span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <i class="ki-outline ki-night-day fs-2"></i>
                                        </span>
                                        <span class="menu-title" >Light</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-moon fs-2"></i>
														</span>
                                        <span class="menu-title">Dark</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-screen fs-2"></i>
														</span>
                                        <span class="menu-title">System</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                             data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                            <a href="#" class="menu-link px-5">
                              <span class="menu-title position-relative">Language
                                  <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                      @php
                                          $locale = auth()->user()->locale ?? 'en';
                                          $flag = [
                                              'en' => 'uk.svg',
                                              'it' => 'it.svg',
                                              'al' => 'al.svg',
                                              'es' => 'es.svg',
                                              'fr' => 'fr.svg',
                                              'de' => 'de.svg'
                                          ][$locale];
                                          $language = [
                                              'en' => 'English',
                                              'it' => 'Italian',
                                              'al' => 'Albanian',
                                              'es' => 'Spanish',
                                              'fr' => 'French',
                                              'de' => 'German',
                                          ][$locale];
                                      @endphp

                                      {{ $language }}
                             <img class="w-15px h-15px rounded-1 ms-2" src="{{ asset('metronic/assets/media/flags/' . $flag) }}" alt="" />
                            </span>
                          </span>
                            </a>
                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <!-- Language Options -->
                                @foreach(['en' => 'English', 'al' => 'Albanian', 'it' => 'Italian', 'es' => 'Spanish','fr' => 'France','de' => 'German',] as $locale => $language)
                                    <div class="menu-item px-3">
                                        <form method="post" action="{{ route('company.update_locale') }}">
                                            @csrf
                                            <input type="hidden" name="locale_val" value="{{ $locale }}">
                                            <button  type="submit" style="border: none; background: none;" class="menu-link d-flex px-5 active">
                                          <span class="symbol symbol-20px me-4">
                                              <img class="rounded-1" src="{{ asset('metronic/assets/media/flags/' . $locale . '.svg') }}" alt="{{ $language }}" />
                                          </span>
                                                {{ $language }}
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5 my-1">
                            <a href="account/settings.html" class="menu-link px-5">Account Settings</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <form method="POST" action="{{route('logout')}}" id="logout_form">
                                @csrf
                                <a href="javascript:void(0)" onclick="document.getElementById('logout_form').submit();" class="menu-link px-5">Sign Out</a>
                            </form>
                        </div>
                        @auth
                            @if(session('impersonated_by'))
                                <!--begin::Menu item -->
                                <div class="menu-item px-5">
                                    <form method="GET" action="{{route('leave_impersonate')}}" id="leave-impersonation-form" >
                                        <a href="javascript:void(0)" onclick="document.getElementById('leave-impersonation-form').submit();" class="menu-link px-5">Leave Impersonation</a>
                                    </form>
                                </div>
                            @endif
                        @endauth
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>

