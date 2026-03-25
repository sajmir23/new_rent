<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-title">Booking & Payments</span>
        <span class="menu-arrow d-lg-none"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.booking_statuses.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-status fs-2"></i></span>
                <span class="menu-title">Booking Statuses</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.payment_statuses.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-wallet fs-2"></i></span>
                <span class="menu-title">Payment Status</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.cancellation_reasons.index')}}">
                <span class="menu-icon"><i class="fas fa-clipboard-list text-red-500"></i></span>
                <span class="menu-title">Cancellation Reasons</span>
            </a>
        </div>

        <!-- Location Management -->
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.city.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-geolocation-home fs-2"></i></span>
                <span class="menu-title">Cities</span>
            </a>
        </div>
    </div>
    <!--end:Menu sub-->
</div>
