<?php

namespace App\Models\Company;

use App\Models\Admin\Brand;
use App\Models\Admin\QueryBuilders\VehicleModelQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;

    protected $table = 'vehicle_models';

    protected $fillable = [
        'title',
        'status',
        'brand_id',
    ];

    public function brands()
    {
        return $this->BelongsTo(Brand::class, 'brand_id', 'id');
    }

    public function newEloquentBuilder($query): VehicleModelQueryBuilder
    {
        return new VehicleModelQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return ucwords($this->title);
    }

    public function getvehiclesLabelAttribute(): string
    {
        $brand = $this->brands->title;
        $model = ucwords(strtolower($this->title));

        return "{$brand} - {$model}";
    }
}