<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard'); // Redirect to home or desired route
        }
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard'); // Redirect to home or desired route
        }

        $request->authenticate();

        $request->session()->regenerate();

        $user = \auth()->user();

        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        $pattern = '/\b(?:Chrome|Safari|Firefox|Opera|Edge|IE)\b/i';

        if (preg_match($pattern, $userAgent, $matches)) {
            $browserName = $matches[0];
            $exactBrowser =  $browserName  ? : "--" ;
        }


        DB::table('login_history')->insert([
            'user_id'    => $user->id,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'browser'    => $exactBrowser,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);


        if ($user->user_type == UserTypesEnum::COMPANY_ADMIN || $user->user_type == UserTypesEnum::STAFF ){
            return redirect()->intended(route('company.dashboard', absolute: false));
        }else{
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}



