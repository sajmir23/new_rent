<div class="d-flex flex-shrink-0">
{{--    @if(auth()->user()->hasPermission('bookings.view_any'))--}}
    <a target="_blank" href="{{route('company.bookings.show', $booking->id)}}">
            <span class="btn btn-bg-light btn-active-color-primary btn-sm me-1" >
                <i class="ki-outline ki-eye fs-2"></i>
            </span>
    </a>
{{--    @endif--}}

    @if(auth()->user()->hasPermission('bookings.cancel') && $booking->created_by != null &&  in_array($booking->booking_status_id, [
        \App\Models\Admin\BookingStatus::PENDING,
        \App\Models\Admin\BookingStatus::CONFIRMED
    ]))
        <a onclick="showDeleteModal({{$booking->id}})" data-id="{{$booking->id}}"  class="btn btn-icon btn-light-danger btn-active-color-white btn-sm">
            <i class="ki-outline ki-cross-circle fs-2"></i>
        </a>
    @endif
</div>



