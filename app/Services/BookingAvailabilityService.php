<?php

namespace App\Services;

use App\Models\Company\Booking;
use App\Models\Admin\BookingStatus;
use Carbon\Carbon;

class BookingAvailabilityService
{
    public function isVehicleAvailable(int $vehicleId, Carbon $pickupDateTime, Carbon $dropoffDateTime): bool
    {
        return !Booking::where('vehicle_id', $vehicleId)
            ->whereIn('booking_status_id', [BookingStatus::CONFIRMED, BookingStatus::ACTIVE,BookingStatus::PENDING])  //BookingStatus:PENDING
            ->where(function ($query) use ($pickupDateTime, $dropoffDateTime) {
                // Overlapping datetime check
                $query->whereRaw(
                    '(pickup_date + INTERVAL TIME_TO_SEC(pickup_time) SECOND) < ? AND (dropoff_date + INTERVAL TIME_TO_SEC(dropoff_time) SECOND) > ?',
                    [$dropoffDateTime, $pickupDateTime]
                );
            })
            ->exists();
    }
}