<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    private $userService;
    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->userService = $userServiceInterface;
    }
    public function userLogin(UserLoginRequest $request) {
        $credentials = $request->validated();
        $data = $this->userService->login($credentials);
        if (!$data) {
            return response()->json(['message' => 'login failed']);
        }
        return response()->json(['message' => 'login successful', 'data' => $data],200);
    }


}
