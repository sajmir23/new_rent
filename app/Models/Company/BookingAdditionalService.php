<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class BookingAdditionalService extends Model
{
    protected $table = 'booking_additional_services';

    protected $fillable = [
        'booking_id',
        'additional_service_id',
        'quantity',
        'price',
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class, 'booking_id','id');
    }

    public function additional_service()
    {
        return $this->belongsTo(AdditionalService::class, 'additional_service_id','id');
    }
}

