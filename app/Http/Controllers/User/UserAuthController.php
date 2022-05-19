<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest; 
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
     * Summary of userRegister
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userRegister(UserRegisterRequest $request) {
        $validated = $request->validated();
        $status = $this->userService->register($validated);
        if (!$status) {
            return response()->json(['message' => 'register failed.']);
        }
        return response()->json(['message' => 'register successful'],200);
    
    }
}
