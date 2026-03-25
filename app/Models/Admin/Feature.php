<?php

namespace App\Models\Admin;

use App\Models\Company\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $table = 'features';

    protected $fillable = [
        'title',
        'slug',
        'status',
    ];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class,'feature_vehicle','feature_id','vehicle_id');
    }

}
