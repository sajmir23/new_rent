<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellation_Reasons extends Model
{
    /** @use HasFactory<\Database\Factories\CancellationReasonsFactory> */
    use HasFactory;
    protected $table = 'cancellation_reasons';

    protected $fillable = [
        'title_en',
        'title_it',
        'title_al',
        'title_es',
        'title_fr',
        'title_de',
        'status',
    ];
}
