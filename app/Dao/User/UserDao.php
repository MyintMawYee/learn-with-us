<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserDao implements UserDaoInterface
{

    /**
     * Summary of login
     * @param mixed $validated
     * @return Object
     */
    public function login($validated)
    {
        $user = User::where('email', $validated['email'])->first();
        return $user;
    }

    /**
     * Summary of register
     * @param mixed $validated
     */
    public function register($validated)
    {
        $user = new User;
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);
        $status = $user->save();
        return $status;
    }

    /**
     * Summary of logout
     * @param Request $request
     * @return bool
     */
    public function logout(Request $request)
    {
        $logout = $request->user()->token()->revoke();
        return $logout;
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
     * Summary of show users
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUser()
    {
        return User::select('users.id as user_id', 'users.name as user_name', 'users.email as email', 'courses.name as name')
            ->leftjoin('purchases', 'purchases.user_id', 'users.id')
            ->leftjoin('courses', 'courses.id', 'purchases.course_id')
            ->where('type', '1')
            ->get();
    }

    /**
     * Summary of show users
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::findOrFail($id);
        return $users;
    }

    /**
     * Summary of disable users
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function disableUser($id)
    {
        $users = User::find($id);
        if ($users->disable == 1) {
            $users->disable = 0;
        } else {
            $users->disable = 1;
        }
        return $users->save();
    }

    /**
     * Summary of changePassword
     * @param $request
     */
    public function changePassword($request)
    {
        $users = User::findorfail($request['id']);
        //$user->password;
        if(!Hash::check($request['old_password'],$users->password)){
            return false;
        }else{
            return User::where('id', '=', $request['id'] )->update(['password' => Hash::make($request['confirm_password'])]);
        }
    }

    /**
     * Count all User
     *
     * @return \Illuminate\Http\Response
     */
    public function countUser()
    {
        $users = User::all()->where('type', '1')->count();
        return $users;
    }
}
