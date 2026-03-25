<?php

namespace App\Models\Company;

use App\Models\Traits\HasCompanyOwnership;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonalPrice extends Model
{
    use HasFactory, HasCompanyOwnership;

    protected $table = 'seasonal_prices';

    protected $fillable = [
        'company_id',
        'start_date',
        'end_date',
        'rate_multiplier',
    ];
}
