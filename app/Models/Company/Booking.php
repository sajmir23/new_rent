<?php

namespace App\Models\Company;

use App\Models\Admin\BookingStatus;
use App\Models\Admin\Company;
use App\Models\Admin\PaymentStatus;
use App\Models\Traits\HasCompanyOwnership;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, HasCompanyOwnership;

    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'first_name',
        'last_name',
        'birthday',
        'email',
        'phone',
        'additional_phone',
        'days',
        'daily_rate',
        'total_price',
        'addons_total',
        'pickup_date',
        'dropoff_date',
        'pickup_time',
        'dropoff_time',
        'ways_of_contact',
        'vehicle_id',
        'company_id',
        'pickup_location',
        'dropoff_location',
        'booking_status_id',
        'cancelled_at',
        'deliveries_total',
        'additional_service_id',
        'notes',
        'session_id',
        'created_by',
        'insurance_id',
        'commission_amount',
        'payment_gateway',
    ];


    public function additionalServices()
    {
        return $this->belongsToMany(AdditionalService::class, 'booking_additional_services','booking_id','additional_service_id')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function pickUpLocation()
    {
        return $this->belongsTo(Delivery::class, 'pickup_location', 'id');
    }

    public function DropOffLocation()
    {
        return $this->belongsTo(Delivery::class, 'dropoff_location', 'id');
    }

    public function bookingStatus()
    {
        return $this->belongsTo(BookingStatus::class, 'booking_status_id', 'id');
    }

    public function getServiceNamesAttribute()
    {
        return $this->services->pluck('title_en')->join(', ');
    }

}
