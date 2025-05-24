<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiOnBoardingMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('api')->user()->stripe_account_id) {
            return $next($request);
        }

        return Helper::jsonResponse(false, 'Stripe Not Connect.', 422, []);
    }
}