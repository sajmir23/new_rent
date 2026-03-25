<!--begin:Menu item-->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-title">Rental Operations</span>
        <span class="menu-arrow d-lg-none"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">

        <!-- Vehicles -->
        <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
            <span class="menu-link">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-car-2 fs-2"></i>
                </span>
                <span class="menu-title">Vehicles</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.vehicles.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">All Vehicles</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.vehicles.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">New Vehicle</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bookings -->
        <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
            <span class="menu-link">
                 <span class="menu-icon text-dark">
                     <i class="ki-outline ki-calendar fs-2"></i>
                 </span>
                <span class="menu-title">Bookings</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.bookings.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">All Bookings</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.bookings.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">New Booking</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.bookings.calendar') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Calendar</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Seasonal Rates -->
        <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
            <span class="menu-link">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-star fs-2"></i>
                </span>
                <span class="menu-title">Seasonal Rates</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.seasonal_prices.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">All Seasonal Rates</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.seasonal_prices.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">New Seasonal Rate</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tariffs -->
        <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
            <span class="menu-link">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-price-tag fs-2"></i>
                </span>
                <span class="menu-title">Tariffs</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.tariff.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">All Tariffs</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.tariff.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">New Tariff</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Delivery -->
        <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
            <span class="menu-link">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-map fs-2"></i>
                </span>
                <span class="menu-title">Delivery</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                <div class="menu-item">
                    <a class="menu-link" href="{{route('company.deliveries.index')}}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">All Deliveries</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{route('company.deliveries.create')}}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">New Delivery</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Insurances -->
        <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
            <span class="menu-link">
               <span class="menu-icon text-dark">
                   <i class="ki-outline ki-shield fs-2"></i>
               </span>
               <span class="menu-title">Insurances</span>
               <span class="menu-arrow"></span>
           </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.insurances.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">All Insurances</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.insurances.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">New Insurance</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Services -->
        <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
            <span class="menu-link">
               <span class="menu-icon text-dark">
                   <i class="ki-outline ki-briefcase fs-2"></i>
               </span>
               <span class="menu-title">Additional Services</span>
               <span class="menu-arrow"></span>
           </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.additional_services.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">All Services</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('company.additional_services.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">New Service</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <!--end:Menu sub-->
</div>
<!--end:Menu item-->
