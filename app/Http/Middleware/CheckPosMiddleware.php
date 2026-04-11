<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PosDevice;
use Illuminate\Support\Facades\Log;

class CheckPosMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = request()->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized: Missing token'
            ], 401);
        }

        $pos = PosDevice::where('api_token', $token)
            ->where('status', "active")
            ->first();

        if (!$pos ) {
            return response()->json(['error' => 'Unauthorized2'], 401);
        }

        $request->attributes->set('pos', $pos);



        return $next($request);
    }
}
