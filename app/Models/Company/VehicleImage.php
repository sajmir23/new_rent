<?php

namespace App\Models\Company;

use App\Models\Traits\HasCompanyOwnership;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleImage extends Model
{
    use HasFactory, HasCompanyOwnership;

    protected $table = 'vehicle_images';

    protected $fillable = [
        'vehicle_id',
        'created_by',
        'name',
        'path',
        'mime',
        'size',
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
