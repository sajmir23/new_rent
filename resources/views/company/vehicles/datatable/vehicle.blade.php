<div>
    <a class="text-primary semi-bold fs-6">{{ $vehicle->title ?? '—' }}</a>

    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Model:</span>
        <span class="text-primary-emphasis ms-1">{{ $vehicle->vehicleModel->title ?? '—' }}</span>
    </div>

    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Brand:</span>
        <span class="text-primary-emphasis ms-1">{{ $vehicle->vehicleModel->brands->title ?? '—' }}</span>
    </div>
</div>