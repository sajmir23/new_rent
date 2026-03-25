<div class="d-flex flex-column gap-2 ">
    <!-- Staff Email -->
    <div class="d-flex align-items-center gap-2 text-dark">
        <span class="fw-semibold text-muted">Email:</span>
        <span class="text-primary-emphasis">{{ $staff->email ?? 'N/A' }}</span>
    </div>

    <!-- Staff Phone -->
    <div class="d-flex align-items-center gap-2 text-dark">
        <span class="fw-semibold text-muted">Phone:</span>
        <span class="text-success">{{ $staff->phone_number ?? 'N/A' }}</span>
    </div>

    <!-- Staff Address -->
    <div class="d-flex align-items-center gap-2 text-dark">
        <span class="fw-semibold text-muted">Address:</span>
        <span class="text-info">{{ $staff->address ?? 'N/A' }}</span>
    </div>
</div>
