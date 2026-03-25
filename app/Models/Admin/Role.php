<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'title',
        'description',
        'notes',
        'status',
        'background_color',
        'text_color',
        'company_id',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
