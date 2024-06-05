<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUser;
use App\DTO\LoginUserDTO;
use App\DTO\RegisterUserDTO;
use App\Http\Requests\RegisterUser;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Services\UserService;

class AuthController extends Controller
{
    use HttpResponse;

    public function __construct(protected UserService $userService)
    {
    }

    public function login(LoginUser $request)
    {
        $request->validated($request->only(['email', 'password']));

        $loginUserDTO = new LoginUserDTO(
            email: $request->email,
            password: $request->password
        );

        return $this->userService->login($loginUserDTO);
    }

    public function register(RegisterUser $request)
    {

        $request->validated($request->only(['userName', 'email', 'password']));

        $registerUserDTO = new RegisterUserDTO(
            userName: $request->userName,
            email: $request->email,
            password: $request->password
        );

        return $this->userService->register($registerUserDTO);
    }

    public function logout(Request $request)
    {
        return $this->userService->logout($request->user());
    }
}
