<?php

namespace App\Models\Admin;

use App\Models\Admin\QueryBuilders\FuelTypesQueryBuilder;
use App\Models\Admin\QueryBuilders\VehicleCategoriesQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelTypes extends Model
{
    use HasFactory;

    protected $table = 'fuel_types';

    protected $fillable = [
        'title_en',
        'title_it',
        'title_al',
        'title_es',
        'title_fr',
        'title_de',
        'status',
    ];

    public function newEloquentBuilder($query): FuelTypesQueryBuilder
    {
        return new FuelTypesQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {

        return $this->{"title_en"};
    }
}



