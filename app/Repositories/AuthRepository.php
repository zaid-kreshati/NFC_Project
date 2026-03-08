<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{

    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole($data['role']);
        return $user;
    }
    public function login($request): array
    {
        $credentials = $request->only('email', 'password');
        if (! Auth::attempt($credentials)) {
            throw new Exception('Invalid credentials');
        }

        $user = User::where('id', Auth::id())->first();

        if ($request['device_token']) {
            $user->update([
                'device_token' => $request['device_token'],
            ]);
            $user->save();
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $role = $user->getRoleNames()->first();

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'role' => $role,
            'token' => $token,
        ];
    }

   

}
