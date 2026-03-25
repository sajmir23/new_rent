<?php

namespace App\Services;

use App\Enums\UserTypesEnum;
use App\Http\Requests\Admin\UsersStoreRequest;
use App\Models\Admin\BookingStatus;
use App\Models\Admin\PaymentStatus;
use App\Models\Admin\VehicleStatus;
use App\Models\Company\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class BookingStatusSyncService
{
    /**
     * Map booking statuses to vehicle statuses.
     * Make sure these constants match your models.
     */
    protected array $statusMap = [
        BookingStatus::CONFIRMED => VehicleStatus::BOOKED ,
        BookingStatus::ACTIVE    => VehicleStatus::RENTED,
        BookingStatus::CANCELLED => VehicleStatus::AVAILABLE,
        BookingStatus::COMPLETED => VehicleStatus::AVAILABLE,
    ];

    protected array $paymentStatusMap = [
        BookingStatus::CONFIRMED => PaymentStatus::PAID ,
        BookingStatus::ACTIVE    => PaymentStatus::PAID ,
    ];


    /**
     * Sync vehicle status based on booking status.
     */
    public function syncVehicleStatus(Booking $booking): void
    {
        $vehicleStatusId = $this->statusMap[$booking->booking_status_id] ?? null;

        if ($vehicleStatusId) {
            $booking->vehicle->update([
                'vehicle_status_id' => $vehicleStatusId,
            ]);
        }
        $this->syncPaymentStatus($booking);
    }

    public function syncPaymentStatus(Booking $booking): void
    {
        $paymentStatus = $this->paymentStatusMap[$booking->booking_status_id] ?? null;

        if ($paymentStatus && $booking->payment) {
            $booking->payment->update([
                'payment_status_id' => $paymentStatus,
            ]);
        }
    }

    /**
     * Optional helper methods for pickup/dropoff
     */
    public function pickup(Booking $booking): void
    {
        $booking->update(['booking_status_id' => BookingStatus::ACTIVE]);
        $this->syncVehicleStatus($booking);
    }

    public function dropoff(Booking $booking): void
    {
        $booking->update(['booking_status_id' => BookingStatus::COMPLETED]);
        $this->syncVehicleStatus($booking);
    }

}