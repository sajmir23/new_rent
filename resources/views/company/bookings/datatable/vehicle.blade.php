<div class="d-flex flex-column gap-1">
    <!-- Vehicle Title -->
    <div class="text-gray-900 fs-6 fw-bold">
        {{ $booking->vehicle->title ?: '—' }}
    </div>

    <!-- Model & Brand -->
    <div class="text-gray-900 fs-6 fw-bold">
        Model: <span class="text-muted fw-normal">
            {{ $booking->vehicle->vehicleModel->title ?? '—' }} / {{ $booking->vehicle->vehicleModel->brands->title ?? '—' }}
        </span>
    </div>

    <!-- Plate -->
    <div class="text-gray-900 fs-6 fw-bold">
        Plate: <span class="text-muted fw-normal">
            {{ $booking->vehicle->plate ?: '—' }}
        </span>
    </div>
</div>
