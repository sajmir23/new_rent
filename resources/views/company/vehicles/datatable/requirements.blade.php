<div>
    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Min Drive Age:</span>
        <span class="text-success-emphasis ms-1">{{  $vehicle->min_drive_age ?? '—' }}</span>
    </div>

    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">Max Drive Age:</span>
        <span class="text-success-emphasis ms-1">{{ $vehicle->max_drive_age ?? '—' }}</span>
    </div>

    <div class="d-block mb-1 fs-7">
        <span class="text-dark fw-semibold">International Licence:</span>
        @if($vehicle->international_licence_required)
            <span class="badge badge-success ms-1">Yes</span>
        @else
            <span class="badge badge-danger ms-1">No</span>
        @endif
    </div>
</div>