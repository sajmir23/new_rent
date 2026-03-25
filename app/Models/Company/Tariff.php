<?php

namespace App\Models\Company;

use App\Models\Traits\HasCompanyOwnership;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory ,HasCompanyOwnership;

    protected $table = 'tariffs';

    protected $fillable = [
        'company_id',
        'min_days',
        'max_days',
        'rate_multiplier',
    ];


}
