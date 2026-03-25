<div class="d-flex flex-column gap-2 ">
    <!-- Company Email -->
    <div class="d-flex align-items-center gap-2 text-dark">
        <span class="fw-semibold text-muted">Email:</span>
        <span class="text-primary-emphasis">{{ $company_admin->email ?? 'N/A' }}</span>
    </div>

    <!-- Company Phone -->
    <div class="d-flex align-items-center gap-2 text-dark">
        <span class="fw-semibold text-muted">Phone:</span>
        <span class="text-success">{{ $company_admin->phone_number ?? 'N/A' }}</span>
    </div>

    <!-- Company Address -->
    <div class="d-flex align-items-center gap-2 text-dark">
        <span class="fw-semibold text-muted">Address:</span>
        <span class="text-info">{{ $company_admin->address ?? 'N/A' }}</span>
    </div>
</div>
