<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-title">System Management</span>
        <span class="menu-arrow d-lg-none"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
        <!-- Vehicle Management -->
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.vehicle_categories.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-car-2 fs-2"></i></span>
                <span class="menu-title">Vehicle Categories</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.vehicle_statuses.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-dash fs-2"></i></span>
                <span class="menu-title">Vehicle Statuses</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.transmission_types.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-setting-2 fs-2"></i></span>
                <span class="menu-title">Transmission Types</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.features.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-gear fs-2"></i></span>
                <span class="menu-title">Vehicle Features</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.fuel_types.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-drop fs-2"></i></span>
                <span class="menu-title">Fuel Types</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.brands.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-car-3 fs-2"></i></span>
                <span class="menu-title">Brands</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('admin.vehicle_model.index')}}">
                <span class="menu-icon"><i class="ki-outline ki-car fs-2"></i></span>
                <span class="menu-title">Vehicle Models</span>
            </a>
        </div>
    </div>
    <!--end:Menu sub-->
</div>
