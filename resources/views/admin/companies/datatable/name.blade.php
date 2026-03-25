<div class="d-flex flex-column gap-3 p-4 ">
    <!-- Company Name -->
    <div class="d-flex align-items-center gap-2 flex-nowrap">
        <i class="ki-duotone ki-building fs-2 text-info"></i>
        <span class="fs-6 fw-bold text-gray-800 text-nowrap">{{ $company->name }}</span>
    </div>

    <!-- Email -->
    <div class="d-flex align-items-center gap-2 flex-nowrap">
        <i class="ki-duotone ki-sms fs-2 text-info"></i>
        <span class="fs-6 text-success-emphasis text-nowrap">
            <strong>Email:</strong> {{ $company->email ?? 'N/A' }}
        </span>
    </div>

    <!-- Phone -->
    <div class="d-flex align-items-center gap-2 flex-nowrap">
        <i class="ki-duotone ki-call fs-2 text-info"></i>
        <span class="fs-6 text-success-emphasis text-nowrap">
            <strong>Phone:</strong> {{ $company->phone ?? 'N/A' }}
        </span>
    </div>
</div>
