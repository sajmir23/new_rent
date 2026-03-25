<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class NotificationController extends Controller
{
    /**
     * Display the list of notifications for the system admin.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $admin=User::where('user_type',UserTypesEnum::SYSTEM_ADMIN)->first();

        $notifications=$admin->notifications()->latest()->paginate(15);

        return view('admin.notifications.index')->with([
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a specific notification as read.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */

    public function marked(Request $request,$id)
    {
        $system_admin=User::where('user_type',UserTypesEnum::SYSTEM_ADMIN)->first();

        $notifications=$system_admin->notifications()->findOrFail($id);

        if(isNull($notifications->read_at)){
            $notifications->markAsRead();
        }

        if($request->ajax())
        {
            return response()->json([
                'success' => true,
                'message'=>  'Notification marked as read'
            ]);
        }

        return redirect()->back()->with([
            'success' => true,
            'message'=>  'Notification marked as read']);
    }
}
