<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';


    protected $guarded = ['id'];


    public function user(){

        return $this->belongsTo(User::class,'user_id');
    }

    public function scopeFilterSearch(Builder $query, array $filters): void
    {
        // Conditional if the filter has a key "description", and is not null, will execute the query
        $query->when($filters['description'] ?? false, function(Builder $query, $description){
            $query->where(function($query) use ($description){
                $query->where('description',"LIKE",'%'.$description.'%');
            });
        });

        // Conditional if the filter has a key "priority", and is not null, will execute the query
        $query->when($filters['priority'] ?? false, function(Builder $query, $priority){
            $query->where(function($query) use ($priority){
                $query->where('priority',$priority);
            });
        });

        // Conditional if the filter has a key "priority", and is not null, will execute the query
        $query->when($filters['user_id'] ?? false, function(Builder $query, $user_id){
            $query->where(function($query) use ($user_id){
                $query->where('user_id',$user_id);
            });
        });

    }

}
