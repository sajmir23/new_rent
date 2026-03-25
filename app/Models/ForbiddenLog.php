<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForbiddenLog extends Model
{

    use HasFactory;

    protected $table  = 'forbidden_logs';

    protected $fillable = [
        'user_id',
        'action',
        'route',
        'additional_info',
        'required_permission',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }}
