<?php

namespace App\Models\Admin;

use App\Models\Admin\QueryBuilders\BrandsQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'title',
        'status',
        'icon',
    ];

    public function newEloquentBuilder($query): BrandsQueryBuilder
    {
        return new BrandsQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return ucwords($this->title);
    }

}
