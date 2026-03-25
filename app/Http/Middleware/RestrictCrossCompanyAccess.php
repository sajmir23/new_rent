<?php

namespace App\Http\Middleware;

use App\Models\Traits\HasCompanyOwnership;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class RestrictCrossCompanyAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = auth()->user();

        foreach ($request->route()->parameters() as $param) {
            if ($param instanceof \Illuminate\Database\Eloquent\Model) {
                // Only enforce check if model uses the trait
                if (in_array(HasCompanyOwnership::class, class_uses_recursive($param))) {
                    if (
                        !is_null($param->company_id) &&
                        !$param->isOwnedByCompany($authUser->company_id)
                    ) {
                        abort(403, 'Unauthorized access to resource from another company.');
                    }
                }
            }
        }

        return $next($request);
    }
}
