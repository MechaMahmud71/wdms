<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Hash;
use App\DTO\LoginUserDTO;
use App\DTO\RegisterUserDTO;

class UserService
{
    use HttpResponse;

    public function login(LoginUserDTO $loginUserDTO)
    {
        if (!Auth::attempt(['email' => $loginUserDTO->email, 'password' => $loginUserDTO->password])) {
            return $this->error("Credential do not match", 404);
        }

        $user = User::where('email', $loginUserDTO->email)->first();

        if (!$user) {
            return $this->error("User is not found", 404);
        }

        $user->token = $user->createToken('API Token')->plainTextToken;

        return $this->success($user);
    }


    public function register(RegisterUserDTO $registerUserDTO)
    {

        $user = User::create([
            'userName' => $registerUserDTO->userName,
            'email' => $registerUserDTO->email,
            'password' => Hash::make($registerUserDTO->password),
        ]);

        $user->token = $user->createToken('API Token')->plainTextToken;

        return $this->success($user);
    }

    public function logout($user)
    {
        $user()->currentAccessToken()->delete();

        return $this->success("Successfully logged out");
    }
}
