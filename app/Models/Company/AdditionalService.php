<?php

namespace App\Models\Company;

use App\Models\Company\QueryBuilders\AdditionalServicesQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalService extends Model
{
    use HasFactory;

    protected $table = 'additional_services';

    protected $fillable = [
        'company_id',
        'title_en',
        'title_it',
        'title_al',
        'title_es',
        'title_de',
        'title_fr',
        'description_en',
        'description_it',
        'description_al',
        'description_es',
        'description_de',
        'description_fr',
        'service_price',
        'status',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_additional_services', 'additional_service_id', 'booking_id')->withTimestamps();
    }


    public function newEloquentBuilder($query): AdditionalServicesQueryBuilder
    {
        return new AdditionalServicesQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return ucwords($this->title_en);
    }
}
