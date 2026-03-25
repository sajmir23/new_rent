<?php

namespace App\Http\Controllers\Company;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    /**
     * Display a paginated list of notifications for the company admin.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $company_admin = User::where('user_type', \App\Enums\UserTypesEnum::COMPANY_ADMIN)->where('company_id', auth()->user()->company_id)->first();
        $notifications=$company_admin->notifications()->latest()->paginate(15);

        return view('company.notifications.index')->with([
            'notifications' => $notifications,

        ]);
    }

    /**
     * Mark a specific notification as read for the company admin.
     *
     * If the request is AJAX, returns a JSON response; otherwise, redirects back with a flash message.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */

    public function marked(Request $request,$id)
    {
        $company_admin=User::where('user_type',UserTypesEnum::COMPANY_ADMIN)->where('company_id',auth()->user()->company_id)->first();

        $notifications=$company_admin->notifications()->findOrFail($id);

        if(is_null($notifications->read_at)){
            $notifications->markAsRead();
        }

        if($request->ajax())
        {
            return response()->json([
                'success' => true,
                'message' => 'Notifications marked as read',
            ]);
        }
        return redirect()->back()->with([
            'success' => true,
            'message'=>  'Notification marked as read']);
    }

}
