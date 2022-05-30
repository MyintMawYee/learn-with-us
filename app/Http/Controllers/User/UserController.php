<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
     * Summary of show user lists
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUser()
    {
        $users =  $this->userService->getAllUser();
        return response()->json([
            'result' => 1,
            'message' => 'Users lists',
            'data' => $users
        ]);
    }

     /**
     * Summary of confirmRegister
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerConfirm(Request $request) 
    {
        $registration = $this->userService->register($request);
        return response()->json([
            "result" => 1,
            "message" => $registration
        ]);
     }

     /**
     * Summary of disable users
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function disableUser($id) 
    {
        $users = $this->userService->disableUser($id);
        return response()->json($users);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = $this->userService->show($id); 
        return response()->json([
            'result' => 1,
            'message' => 'User Details',
            'data' => $users
        ]);
    }

}
