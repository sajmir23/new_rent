<div>
    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Year:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->year?? '—' }}</span>
    </div>

    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Mileage:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->mileage ?? '—' }} Km</span>
    </div>

    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Color:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->color ?? '—' }}</span>
    </div>
</div>