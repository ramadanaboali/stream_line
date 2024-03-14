<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        Log::info('request header is',$request->header());
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', '*')
        ->header('Access-Control-Allow-Credentials', true)
//            ->header('Access-Control-Allow-Headers', 'X-Requested-With,Service-Secret,Content-Type,X-Token-Auth,Authorization')
            ->header('Access-Control-Allow-Headers', '*')
        ->header('Accept', 'application/json');
    }
}
