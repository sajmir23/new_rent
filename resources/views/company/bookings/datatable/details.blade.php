<div class="d-flex flex-column gap-1">
    <!-- Email -->
    <div class="text-gray-900 fs-6 fw-bold">{{ $booking->email ?: '—' }}</div>

    <!-- Phone -->
    <div class="text-gray-900 fs-7 fw-bold">
        Phone: <span class="text-muted fw-normal">{{ $booking->phone ?: '—' }}</span>
    </div>

    <!-- Additional Phone -->
    <div class="text-gray-900 fs-7 fw-bold">
        Additional Phone: <span class="text-muted fw-normal">{{ $booking->additional_phone ?: '—' }}</span>
    </div>
</div>

