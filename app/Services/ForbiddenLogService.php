<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ForbiddenLogService
{
    public function storeForbiddenLog($route = null,$permission = null,$add_info = null){

        $data = [
            'user_id'             => auth()->check() ? auth()->user()->id : null,
            'action'              => 'attempted access',
            'route'               => $route ? : "--",
            'required_permission' => $permission  ? : '--' ,
            'additional_info'     => $add_info  ? : '--' ,
            'created_at'          => Carbon::now()->toDateTimeString(),
            'updated_at'          => Carbon::now()->toDateTimeString(),
        ];

        DB::table('forbidden_logs')->insert($data);

    }
}
