<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActivityLogService
{


    public function storeActivityLog($description = null,$priority = null,$method = null,$action_type = null){

        $data = [
            'user_id'     => auth()->check() ? auth()->user()->id : null,
            'description' => $description,
            'priority'    => $priority,
            'method'      => $method,
            'action_type' => $action_type,
            'created_at'  => Carbon::now()->toDateTimeString(),
            'updated_at'  => Carbon::now()->toDateTimeString(),
        ];

        DB::table('activity_logs')->insert($data);
    }
}
