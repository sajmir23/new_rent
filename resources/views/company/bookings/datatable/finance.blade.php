<div class="d-flex flex-wrap gap-1 align-items-center">
    <div class="text-gray-900 fs-7 fw-bold">
        Daily Rate: <span class="text-muted fw-normal">{{ $booking->daily_rate ?? '—' }} €</span>
    </div>

    <div class="text-gray-900 fs-7 fw-bold">
        Addons Total: <span class="text-muted fw-normal">{{ $booking->addons_total ?? '—' }} €</span>
    </div>

    <div class="text-gray-900 fs-7 fw-bold">
        Total Price: <span class="text-muted fw-normal">{{ $booking->total_price ?? '—' }} €</span>
    </div>
</div>
