<?php

namespace App\Models\Company;

use App\Models\Admin\City;
use App\Models\Admin\Company;
use App\Models\Company\QueryBuilders\DeliveriesQueryBuilder;
use App\Models\Company\QueryBuilders\VehicleQueryBuilder;
use App\Models\Traits\HasCompanyOwnership;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory, HasCompanyOwnership;

    protected $table = 'deliveries';

    protected $fillable = [
        'company_id',
        'city_id',
        'place',
        'price',
        'delivery_time',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function newEloquentBuilder($query): DeliveriesQueryBuilder
    {
        return new DeliveriesQueryBuilder($query);
    }

    public function getLabelAttribute()
    {
        return $this->place;
    }
}
