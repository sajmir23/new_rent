<?php

namespace App\Models\Admin;

use App\Models\Admin\QueryBuilders\CitiesQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = ['name'];


    public function company()
    {
        return $this->hasMany(Company::class, 'company_id', 'id');

    }
    public function newEloquentBuilder($query): CitiesQueryBuilder
    {
        return new CitiesQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return ucwords($this->name);
    }

}
