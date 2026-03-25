@if($admin)
    <div class="d-flex flex-column gap-3 p-4 ">
        <!-- Admin Name -->
        <div class="d-flex align-items-center gap-2 flex-nowrap">
            <i class="ki-duotone ki-user-square fs-2 text-primary"></i>
            <span class="fs-6 fw-medium text-danger-emphasis text-nowrap">
                {{ $admin->first_name }} {{ $admin->last_name }}
            </span>
        </div>

        <!-- Admin Email -->
        <div class="d-flex align-items-center gap-2 flex-nowrap">
            <i class="ki-duotone ki-sms fs-2 text-primary"></i>
            <span class="fs-6 text-nowrap text-gray-600">
                <strong class="text-dark">Email:</strong> {{ $admin->email }}
            </span>
        </div>

        <!-- Admin Phone -->
        <div class="d-flex align-items-center gap-2 flex-nowrap">
            <i class="ki-duotone ki-call fs-2 text-primary"></i>
            <span class="fs-6 text-nowrap text-gray-600">
                <strong class="text-dark">Phone:</strong> {{ $admin->phone_number ?? '' }}
            </span>
        </div>
    </div>
@else
    <span class="badge bg-light-warning text-dark border border-warning">No Admin</span>
@endif
