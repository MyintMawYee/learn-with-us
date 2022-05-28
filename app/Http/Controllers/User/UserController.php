<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordChangeRequest;
use App\Services\Exports\UsersExportService;
use App\Services\Imports\UsersImportService;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * Summary of show user lists
     * @return \Illuminate\Http\JsonResponse
     */
    public function countUser()
    {
        $users =  $this->userService->countUser();
        return response()->json([
            'result' => 1,
            'data' => $users
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param PasswordChangeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(PasswordChangeRequest $request)
    {
        $users = $this->userService->changePassword($request);
        if (!$users) {
            return response()->json([
                'result' => 0,
                'message' => 'Password cannot be changed',
            ], 401);
        }
        return response()->json([
            'result' => 1,
            'message' => 'Password can be changed successfully',
            'data' => $users
        ], 200);
    }

    /**
     * export excel file
     */
    public function export()
    {
        return Excel::download(new UsersExportService, 'users.xlsx');
    }

    /**
     * @return \Illuminate\Support\Collection
     * import excel file
     */
    public function import(Request $request)
    {
        try {
            Excel::import(new UsersImportService, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return response()->json($failures);
        }
    }

    /**
     * Summary of get data for singup confirm page
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegisterConfirm(Request $request)
    {
        return response()->json([
            "result" => 1,
            "message" => 'Signup Comfirm Data',
            "data" => [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => $request['password'],
                'confirm_password' => $request['confirm_password']
            ]
        ]);
    }
}
