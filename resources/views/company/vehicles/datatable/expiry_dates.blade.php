<div>
    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Registration Expiry:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->registration_expiry ?? '—' }}</span>
    </div>
    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Insurance Expiry:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->insurance_expiry ?? '—' }}</span>
    </div>
</div>