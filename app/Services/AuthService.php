<?php

namespace App\Services;

use App\Repositories\AuthRepository;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AuthService
{
    public function __construct(

        protected AuthRepository $authRepository
    ) {}


    public function register(Request $request)
    {

        $data = $this->authRepository->register($request->all());
        return $data;
    }

    public function login(Request $request): array
    {
        return $this->authRepository->login($request);
    }


}
