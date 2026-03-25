<?php

namespace App\Models\Admin;

use App\Enums\UserTypesEnum;
use App\Models\Admin\QueryBuilders\CompaniesQueryBuilder;
use App\Models\Company\Booking;
use App\Models\Company\FailedPayment;
use App\Models\Company\Insurance;
/*use App\Models\Company\Payment;*/
use App\Models\Company\Vehicle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'logo',
        'address',
        'notes',
        'status',
        'working_days',
        'booking_fee_percentage',
        'city_id'
    ];

    protected $casts = [
        'working_days' => 'array',
    ];

    public function insurance()
    {
        return $this->hasMany(Insurance::class, 'company_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'company_id','id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'company_id','id');
    }

    public function admin()
    {
        return $this->hasOne(User::class)->where('user_type', UserTypesEnum::COMPANY_ADMIN);
    }

    public function staff()
    {
        return $this->hasMany(User::class)->where('user_type', UserTypesEnum::STAFF);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'company_id','id');

    }

    public function failedPayment()
    {
        return $this->hasMany(FailedPayment::class, 'company_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function newEloquentBuilder($query): CompaniesQueryBuilder
    {
        return new CompaniesQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return ucwords($this->name);
    }
}
