<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;



class AuthController extends Controller
{
    use JsonResponseTrait;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request): JsonResponse
    {
        try {
            $data = $this->authService->register($request);

            return $this->success($data, 'Registered successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $data = $this->authService->login($request);

            return $this->success($data, 'Logged in successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();
            return $this->success([], 'Logged out successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
