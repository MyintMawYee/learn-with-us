<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
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
    public function loginUser(UserLoginRequest $request) {
        $credentials = $request->validated();
        $data = $this->userService->login($credentials);
        return response()->json($data["res"],$data["status"]);
    }
    
    /**
     * Summary of userRegister
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerUser(UserRegisterRequest $request) {
        $validated = $request->validated();
        $status = $this->userService->register($validated);
        if (!$status) {
            return response()->json(['message' => 'register failed.']);
        }
        return response()->json(['message' => 'register successful'],200);
    }

    /**
     * Summary of logoutUser
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoutUser(Request $request) {
        $status = $this->userService->logout($request);
        return response()->json($status);
    }

}
