<?php

namespace App\Models\Admin;

use App\Models\Admin\QueryBuilders\VehicleStatusesQueryBuilder;
use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    protected $table = 'vehicle_statuses';

    protected $guarded = ['id'];
    // ------------------------------
    // Constants matching DB IDs
    // ------------------------------
    const AVAILABLE   = 1;
    const BOOKED      = 2;
    const MAINTENANCE = 3;
    const INACTIVE    = 4;
    const RENTED      = 5;

    public function newEloquentBuilder($query): VehicleStatusesQueryBuilder
    {
        return new VehicleStatusesQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {

        return $this->{"title_en"};
    }
}