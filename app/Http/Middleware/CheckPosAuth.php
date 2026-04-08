<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PosDevice;

class CheckPosAuth
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
            ->where('is_active', true)
            ->first();

        if (!$pos || $pos->status !== 'active') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->merge([
            'pos_device_id' => $pos->id,
            'branch_id' => $pos->branch_id,
            'store_id' => $pos->branch->store_id,
        ]);

        return $next($request);
    }
}
