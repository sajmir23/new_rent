<div>
    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Vehicle Category:</span>
        <span class="text-success-emphasis ms-1">{{  $vehicle->vehicleCategory->{"title_en"} ?? '—' }}</span>
    </div>

    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Fuel Type:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->fuelType->{"title_en"}?? '—' }}</span>
    </div>

    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Transmission Type:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->transmissionType->{"title_en"} ?? '—' }}</span>
    </div>

</div>