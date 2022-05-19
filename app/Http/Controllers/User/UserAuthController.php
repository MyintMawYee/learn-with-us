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
    /**
     * Summary of 
     * @var mixed
     */

    private $userService;
    /**
     * Summary of __construct
     * @param UserServiceInterface $userServiceInterface
     */
    
    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->userService = $userServiceInterface;
    }

    /**
     * Summary of userLogin
     * @param UserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function userLogin(UserLoginRequest $request) {
        $credentials = $request->validated();
        $data = $this->userService->login($credentials);
        if (!$data) {
            return response()->json([
                'result' => 0,
                'message' => 'Login failed'
            ],401);
        }
        return response()->json([
            'result' => 1,
            'message' => 'Login successful',
            'data' => $data
        ],200);
    }

}
