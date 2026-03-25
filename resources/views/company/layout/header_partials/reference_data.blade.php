<!--begin:Menu item-->
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-title">Reference Data</span>
        <span class="menu-arrow d-lg-none"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">

        <!-- Vehicle Categories -->
        <div class="menu-item">
            <a class="menu-link" href="{{ route('company.vehicle_categories.index') }}">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-car-2 fs-2"></i>
                </span>
                <span class="menu-title">Vehicle Categories</span>
            </a>
        </div>

        <!-- Vehicle Features -->
        <div class="menu-item">
            <a class="menu-link" href="{{ route('company.features.index') }}">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-wrench fs-2"></i>
                </span>
                <span class="menu-title">Vehicle Features</span>
            </a>
        </div>

        <!-- Transmission Types -->
        <div class="menu-item">
            <a class="menu-link" href="{{ route('company.transmission_types.index') }}">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-gear fs-2"></i>
                </span>
                <span class="menu-title">Transmission Types</span>
            </a>
        </div>

        <!-- Fuel Types -->
        <div class="menu-item">
            <a class="menu-link" href="{{ route('company.fuel_types.index') }}">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-drop fs-2"></i>
                </span>
                <span class="menu-title">Fuel Types</span>
            </a>
        </div>

        <!-- Brands -->
        <div class="menu-item">
            <a class="menu-link" href="{{ route('company.brands.index') }}">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-car-3 fs-2"></i>
                </span>
                <span class="menu-title">Brands</span>
            </a>
        </div>

        <!-- Models -->
        <div class="menu-item">
            <a class="menu-link" href="{{ route('company.vehicle_model.index') }}">
                <span class="menu-icon text-dark">
                    <i class="ki-outline ki-car fs-2"></i>
                </span>
                <span class="menu-title">Models</span>
            </a>
        </div>

    </div>
    <!--end:Menu sub-->
</div>
<!--end:Menu item-->