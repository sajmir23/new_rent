<div class="d-flex flex-column gap-2">
    <!--company Name -->
    <div class="d-flex align-items-center gap-2 flex-nowrap">
            <span class="fs-6 fw-medium text-success-emphasis text-nowrap">
                {{ $staff->company->name ?? 'N/A'}}
            </span>
    </div>
    <!-- company Email -->
    <div class="d-flex align-items-center gap-2 flex-nowrap text-gray-700">
            <span class="fs-6 text-nowrap">
                <strong>Email:</strong> {{ $staff->company->email ?? 'N/A'}}
            </span>
    </div>

    <!-- company Phone -->
    <div class="d-flex align-items-center gap-2 flex-nowrap text-gray-700">
            <span class="fs-6 text-nowrap">
                <strong>Phone:</strong> {{ $staff->company->phone ?? 'N/A' }}
            </span>
    </div>
</div>
