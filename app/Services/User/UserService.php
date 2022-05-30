<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class UserService implements UserServiceInterface
{
    private $userDao;

    /**
     * Summary of __construct
     * @param UserDaoInterface $userDaoInterface
     */
    public function __construct(UserDaoInterface $userDaoInterface)
    {
        $this->userDao = $userDaoInterface;
    }

    /**
     * Summary of login
     * @param mixed $validated
     * @return array
     */
    public function login($validated)
    {
        if (!Auth::attempt($validated)) {
            return [
                "result" => intval(Lang::get("messages.fail.result")),
                "message" => Lang::get("messages.loginsuccess.wrongpass")
            ];
        }
        $user = $this->userDao->login($validated);
        if (!$user) {
            return [
                "result" => intval(Lang::get("messages.fail.result")),
                "message" => Lang::get("messages.loginsuccess.fail")
            ];
        }
        $data['token'] = $user->createToken('myToken')->accessToken;
        $data["id"] = $user->id;
        $data['name'] = $user->name;
        $data['type'] = $user->type;
        $data['disable'] = $user->disable;
        return [
            "result" => intval(Lang::get("messages.result.success")),
            "message" => Lang::get("messages.loginsuccess.success"),
            "data" => $data
        ];
    }

    /**
     * Summary of register
     * @param mixed $validated
     */
    public function register($validated)
    {
        return $this->userDao->register($validated);
    }

    /**
     * Summary of logout
     * @param mixed $request
     * @return array
     */
    public function logout($request)
    {
        $status = $this->userDao->logout($request);
        if (!$status) {
            return [
                "result" => intval(Lang::get("messages.result.fail")),
                "message" => Lang::get("messages.logout.fail"),
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.success")),
            "message" => Lang::get("messages.logout.success")
        ];
    }

    /**
     * Summary of confirm register
     * @param mixed $validated
     */
    public function registerconfirm($validated)
    {
        return $this->userDao->registerconfirm($validated);
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUser()
    {
        return $this->userDao->getAllUser();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        return $users= $this->userDao->show($id);
    }

    /**
     * Summary of disable users
     * @param $id
     * @return array
     */
    public function disableUser($id) 
    {
        $users= $this->userDao->disableUser($id);
        if ($users) {
            return [
                'result' => 1,
                'message' => 'success'
            ];
        }
        return [
            'result' => 0,
            'message' => 'failed'
        ];
    }

    /**
     * Count all User
     *
     * @return \Illuminate\Http\Response
     */
    public function countUser()
    {
        return $this->userDao->countUser();
    }

    /**
     * Summary of changePassword
     * @param $request
     * @return 
     */
    public function changePassword($request)
    {
        return $this->userDao->changePassword($request);
    }
}
