<?php

namespace App\Models\Company;

use App\Models\Admin\Company;
use Illuminate\Database\Eloquent\Model;

class FailedPayment extends Model
{
    protected $table = 'failed_payments';

    protected $fillable = [
        'session_id',
        'reason',
        'status',
        'customer_email',
        'vehicle_id',
        'company_id',
        'stripe_data',
    ];

    protected $casts = [
        'stripe_data' => 'array',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}
