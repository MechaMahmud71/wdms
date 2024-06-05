<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\RegisterUser;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponse;

    public function login(LoginUser $request)
    {
        $request->validated($request->only(['email', 'password']));

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        $user['token'] = $user->createToken('API Token')->plainTextToken;


        return $this->success($user);
    }

    public function register(RegisterUser $request)
    {

        $request->validated($request->only(['userName', 'email', 'password']));

        $user = User::create([
            'userName' => $request->userName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user['token'] = $user->createToken('API Token')->plainTextToken;

        return $this->success($user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success("Successfully logged out");
    }
}
