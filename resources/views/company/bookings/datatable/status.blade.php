<div class="d-flex justify-content-start flex-column">
    <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6 mb-2">
        <span class="badge badge-light-success fs-7 py-3 px-4">Booking Status: {{$booking->bookingStatus->{"title_en"} ?? '--' }}</span>
    </a>
    <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">
        <span class="badge badge-light-dark fs-7 py-3 px-4">Payment Status: {{$booking->paymentStatus->{"title_en"} ?? '--' }}</span>
    </a>
</div>