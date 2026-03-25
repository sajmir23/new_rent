<?php

namespace App\Models;

use App\Enums\UserTypesEnum;
use App\Models\Admin\Company;
use App\Models\Admin\QueryBuilders\UsersQueryBuilder;
use App\Models\Admin\Role;
use App\Models\Traits\HasCompanyOwnership;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Impersonate, HasCompanyOwnership;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'locale',
        'role_id',
        'company_id',
        'user_type',
        'status',
        'phone_number',
        'alert_login',
        'last_login',
        'email',
        'password',
        'email_verified_at',
        'approved_google_login',
        'google_id',
        'source_id',
        'address',
        'notes',
        'login_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isSystemAdmin(): bool
    {
        return $this->user_type === UserTypesEnum::SYSTEM_ADMIN;
    }

    public function isCompanyAdmin(): bool
    {
        return $this->user_type === UserTypesEnum::COMPANY_ADMIN;
    }


    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function role(){

        return $this->belongsTo(Role::class,'role_id','id');
    }

    public function hasPermission($permission)
    {
        if (!isset($this->permissionsCache)) {
            $this->permissionsCache = $this->role->permissions->pluck('slug')->toArray();
        }
        return in_array($permission, $this->permissionsCache);
    }

    public function hasAnyPermission($permissions)
    {
        if (!isset($this->permissionsCache)) {
            $this->permissionsCache = $this->role->permissions->pluck('slug')->toArray();
        }
        return !empty(array_intersect($permissions, $this->permissionsCache));
    }



    public function scopeFullName(){

        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    public function scopeFilterSearch(Builder $query, array $filters): void
    {

        // Conditional if the filter has a key "general_search_input", and is not null, will execute the query
        $query->when($filters['general_search_input'] ?? false, function(Builder $query, $general_search_input){
            $query->where(function($query) use ($general_search_input){
                $query->whereAny(['first_name','last_name','email','phone_number'],'LIKE','%'.$general_search_input.'%');

            });
        });

        // Conditional if the filter has a key "first_name", and is not null, will execute the query
        $query->when($filters['first_name'] ?? false, function(Builder $query, $first_name){
            $query->where(function($query) use ($first_name){
                $query->where('first_name',"LIKE",'%'.$first_name.'%');
            });
        });

        // Conditional if the filter has a key "last_name", and is not null, will execute the query
        $query->when($filters['last_name'] ?? false, function(Builder $query, $last_name){
            $query->where(function($query) use ($last_name){
                $query->where('last_name',"LIKE",'%'.$last_name.'%');
            });
        });

        $query->when($filters['email'] ?? false, function(Builder $query, $email){
            $query->where(function($query) use ($email){
                $query->where('email',"LIKE",'%'.$email.'%');
            });
        });

        // Conditional if the filter has a key "status", and is not null, will execute the query
        $query->when($filters['status'] ?? false, function(Builder $query, $status){
            if ($status == 3){return;}
            if ($status == 1){$query->where('status',1);}
            else{$query->where('status','!=',1);}
        });

        // Conditional if the filter has a key "role_id", and is not null, will execute the query
        $query->when($filters['role_id'] ?? false, function(Builder $query, $role_id){
            $query->where(function($query) use ($role_id){
                $query->where('role_id',$role_id);
            });
        });

    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }



    public function newEloquentBuilder($query): UsersQueryBuilder
    {
        return new UsersQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return ucwords($this->fullName());
    }

}
