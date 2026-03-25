<?php

namespace App\Models\Admin;

use App\Models\Admin\QueryBuilders\TransmissionTypesQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransmissionType extends Model
{
    use HasFactory;

    protected $table = 'transmission_types';

    protected $fillable = [
        'title_en',
        'title_it',
        'title_al',
        'title_es',
        'title_fr',
        'title_de',
        'status',
    ];

    public function newEloquentBuilder($query): TransmissionTypesQueryBuilder
    {
        return new TransmissionTypesQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return $this->{"title_en"};
    }
}
