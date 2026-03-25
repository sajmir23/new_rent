<?php

namespace App\Models\Company;

use App\Models\Admin\Company;
use App\Models\Company\QueryBuilders\InsurancesQueryBuilder;
use App\Models\Traits\HasCompanyOwnership;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory, HasCompanyOwnership;

    protected $table = 'insurances';

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
        'price_per_day',
        'has_theft_protection',
        'has_deposit',
        'deposit_price',
        'theft_protection_price'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id','id');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'insurance_id', 'id');
    }

    public function newEloquentBuilder($query): InsurancesQueryBuilder
    {
        return new InsurancesQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return ucwords($this->title_en);
    }
}
