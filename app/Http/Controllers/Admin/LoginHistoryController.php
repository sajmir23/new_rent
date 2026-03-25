<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\LoginHistory;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LoginHistoryController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }


    public function index(Request $request){

        if (! auth()->user()->hasPermission('general.view_login_history')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'general.view_login_history','Can not view login history');
            return view('admin.errors.unauthorized');
        }

        $show_number       = $request->show_number ? : 20;
        $start_date        = $request->start_date  ? Carbon::parse($request->start_date)->startOfDay()->toDatestring() : Carbon::now()->subWeek()->toDateString();
        $end_date          = $request->end_date    ? Carbon::parse($request->end_date)->endOfDay()->toDateString()     : Carbon::now()->endOfDay()->toDateString();
        $users             = User::where('user_type',UserTypesEnum::SYSTEM_ADMIN)->get();

        $user = $request->user_id ? User::findOrFail($request->user_id) : null;

        $login_history = LoginHistory::query()
            ->where('created_at', '>=', Carbon::parse($start_date)->startOfDay()->toDateTimeString())
            ->where('created_at', '<=', Carbon::parse($end_date)->endOfDay()->toDateTimeString())
            ->when($request->user_id !== null, function (Builder $query) use ($request) {
                return $query->where('user_id',$request->user_id);
            })
            ->latest()
            ->paginate($show_number)
            ->withQueryString();

        return view('admin.login_history.index')->with([
            'users'              => $users,
            'login_history'      => $login_history,
            'show_number'        => $show_number,
            'start_date'         => $start_date,
            'end_date'           => $end_date,
            'user'               => $user,
        ]);
    }
}
