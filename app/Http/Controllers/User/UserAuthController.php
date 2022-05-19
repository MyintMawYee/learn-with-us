<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserSericeInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    private $userService;
    public function __construct(UserSericeInterface $userServiceInterface)
    {
        $this->userService = $userServiceInterface;
    }
    public function userLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $data = $this->userService->login($credentials);
        if (!$data) {
            return response()->json(['message' => 'login failed']);
        }
        return response()->json(['message' => 'login successful', 'data' => $data],200);
    }


}
