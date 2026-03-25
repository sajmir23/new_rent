<div>
    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Plate:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->plate ?? '—' }}</span>
    </div>

    <div class="d-block fs-7">
        <span class="text-dark fw-semibold">VIN:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->vin ?? '—' }}</span>
    </div>
</div>