<?php

namespace App\Http\Middleware;

use App\Enums\UserTypesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() &&  Auth::user()->user_type == UserTypesEnum::COMPANY_ADMIN || Auth::user()->user_type == UserTypesEnum::STAFF ) {
            return $next($request);
        }else{
            Auth::logout();
        }

        return redirect('/');
    }
}
