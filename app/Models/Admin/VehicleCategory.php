<?php

namespace App\Models\Admin;

use App\Models\Admin\QueryBuilders\VehicleCategoriesQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
    use HasFactory;

    protected $table = 'vehicle_categories';

    protected $fillable = [
        'title_en',
        'title_it',
        'title_al',
        'title_es',
        'title_fr',
        'title_de',
        'status',
        'icon',
    ];

    public function newEloquentBuilder($query): VehicleCategoriesQueryBuilder
    {
        return new VehicleCategoriesQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return $this->{"title_en"};
    }
}
