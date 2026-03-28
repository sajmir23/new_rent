<?php

namespace App\Models\Company;

use App\Models\Admin\Company;
use App\Models\Admin\Feature;
use App\Models\Admin\FuelTypes;
use App\Models\Admin\QueryBuilders\BookingStatusesQueryBuilder;
use App\Models\Admin\TransmissionType;
use App\Models\Admin\VehicleCategory;
use App\Models\Admin\VehicleStatus;
use App\Models\Company\QueryBuilders\VehicleQueryBuilder;
use App\Models\Traits\HasCompanyOwnership;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, HasCompanyOwnership;

    protected $table = 'vehicles';

    protected $fillable = [
        'company_id',
        'vehicle_model_id',
        'vehicle_category_id',
        'fuel_type_id',
        'transmission_type_id',
        'vehicle_status_id',
        'created_by',
        'updated_by',
        'title',
        'slug',
        'base_daily_rate',
        'plate',
        'vin',
        'registration_expiry',
        'insurance_expiry',
        'year',
        'mileage',
        'color',
        'notes',
        'seats',
        'engine_size',
        'min_drive_age',
        'max_drive_age',
        'international_licence_required',
    ];


    protected $casts =
        [
        'insurance_expiry'      => 'date',
        'registration_expiry'   => 'date',
    ];

    public function features()
    {
        return $this->belongsToMany(Feature::class,'feature_vehicle','vehicle_id','feature_id');
    }

    public function images() {
        return $this->hasMany(VehicleImage::class, 'vehicle_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id', 'id');
    }

    public function vehicleCategory()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id', 'id');
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelTypes::class, 'fuel_type_id', 'id');
    }

    public function transmissionType()
    {
        return $this->belongsTo(TransmissionType::class, 'transmission_type_id', 'id');
    }

    public function vehicleStatus()
    {
        return $this->belongsTo(VehicleStatus::class,'vehicle_status_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function failedPayment()
    {
        return $this->hasMany(FailedPayment::class, 'vehicle_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class,'vehicle_id','id');
    }

    public function newEloquentBuilder($query): VehicleQueryBuilder
    {
        return new VehicleQueryBuilder($query);
    }

    public function getLabelAttribute()
    {
        return $this->title;
    }

    public function scopeBaseData($query)
    {
        return $query
            ->with([
                'vehicleModel:id,brand_id,title',
                'vehicleModel.brands:id,title',
                'company:id,city_id,booking_fee_percentage',
                'company.city:id,name',
                'vehicleCategory:id,title_en,title_it,title_al,title_es,title_fr,title_de',
                'fuelType:id,title_en,title_it,title_al,title_es,title_fr,title_de',
                'transmissionType:id,title_en,title_it,title_al,title_es,title_fr,title_de',
                'images:id,vehicle_id,path'
            ])
            ->select(
                'id','title','slug','year','engine_size','seats',
                'base_daily_rate','fuel_type_id','vehicle_model_id',
                'company_id','vehicle_category_id','transmission_type_id','min_drive_age',
                'max_drive_age', 'international_licence_required',
            )
            ->whereIn('vehicle_status_id', [
                VehicleStatus::AVAILABLE ?? 1,
                VehicleStatus::BOOKED ?? 2,
                VehicleStatus::RENTED ?? 5,
            ]);
    }


    public function scopeFilter($query, $filters)
    {
        /*$query->when(isset($filters['pickupDate'], $filters['dropoffDate']), function ($q) use ($filters) {

            $start = $filters['pickupDate'] . ' ' . ($filters['pickupTime'] ?? '00:00');
            $end   = $filters['dropoffDate'] . ' ' . ($filters['dropoffTime'] ?? '23:59');

            $q->whereDoesntHave('bookings', function ($sub) use ($start, $end) {
                $sub->whereRaw("
            CONCAT(pickup_date, ' ', pickup_time) < ?
            AND CONCAT(dropoff_date, ' ', dropoff_time) > ?
        ", [$end, $start]);
            });
        });*/

        $query->when($filters['vehicleCategories'] ?? null, function ($q, $categories) {
            $q->whereIn('vehicle_category_id', (array) $categories);
        });

        $query->when($filters['engine'] ?? null, function ($q, $engines) {
            $q->whereIn('fuel_type_id', (array) $engines);
        });

        $query->when($filters['engine_size'] ?? null, fn($q, $engine_size) => $q->where('engine_size', '>=', $engine_size));

        $query->when($filters['gear_box'] ?? null, function ($q, $gear_box) {
            $q->whereIn('transmission_type_id', (array) $gear_box);
        });

        $query->when($filters['seats'] ?? null, fn($q, $seats) => $q->where('seats', '>=', $seats));

        $query->when(isset($filters['price_min']), function ($q) use ($filters) {
            $q->where('base_daily_rate', '>=', $filters['price_min']);
        });

        $query->when(isset($filters['price_max']), function ($q) use ($filters) {
            $q->where('base_daily_rate', '<=', $filters['price_max']);
        });

        $query->when(isset($filters['year_min']), function ($q) use ($filters) {
            $q->where('year', '>=', $filters['year_min']);
        });

        $query->when(isset($filters['year_max']), function ($q) use ($filters) {
            $q->where('year', '<=', $filters['year_max']);
        });

        $query->when($filters['electric_only'] ?? false, function ($q) {
            $q->whereHas('fuelType', fn($fuel) => $fuel->where('title_en', 'like', '%electric%'));
        });

        $query->when($filters['brand'] ?? null, function ($q, $brand) {
            $q->whereHas('vehicleModel.brands', fn($b) => $b->where('title', $brand));
        });

        $query->when($filters['model'] ?? null, function ($q, $model) {
            $q->whereHas('vehicleModel', fn($m) => $m->where('title', $model));
        });

        $query->when($filters['city'] ?? null, function ($q, $city) {
            $q->whereHas('company.city', fn($sub) => $sub->where('name', $city));
        });

        $query->when($filters['delivery'] ?? false, function ($q) use ($filters) {
            if (!empty($filters['city'])) {
                $q->whereHas('company.deliveries.city', fn($c) =>
                $c->where('name', $filters['city'])
                );
            } else {
                $q->whereHas('company.deliveries');
            }
        });

        $query->when($filters['sort'] ?? null, function ($q, $sort) {
            if ($sort === 'cheap') {
                $q->orderBy('base_daily_rate', 'asc');
            } elseif ($sort === 'expensive') {
                $q->orderBy('base_daily_rate', 'desc');
            }
        });
    }
}
