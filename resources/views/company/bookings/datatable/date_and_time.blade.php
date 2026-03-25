<div class="d-flex flex-column gap-2">
    <!-- Pickup -->
    <div class="fs-6">
        <span class="fw-bold text-gray-800">Pickup:</span>
        <span class="text-muted fs-7">{{ $booking->pickup_date ?? '—' }} / {{ $booking->pickup_time ?? '—' }}</span>
    </div>

    <!-- Dropoff -->
    <div class="fs-6">
        <span class="fw-bold text-gray-800">Dropoff:</span>
        <span class="text-muted fs-7">{{ $booking->dropoff_date ?? '—' }} / {{ $booking->dropoff_time ?? '—' }}</span>
    </div>
</div>

