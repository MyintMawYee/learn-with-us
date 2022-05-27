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
     * @return array|bool
     */
    public function login($validated)
    {
        if (!Auth::attempt($validated)) {
            return false;
        }
        $user = User::where('email', $validated['email'])->first();
        $data['token'] = $user->createToken('myToken')->accessToken;
        $data["id"] = $user->id;
        $data['name'] = $user->name;
        $data['type'] = $user->type;
        $data['disable'] = $user->disable;
        return $data;
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
        $users = User::all();
        return $users;
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
     * Count all User
     *
     * @return \Illuminate\Http\Response
     */
    public function countUser()
    {
        $users = User::all()->count();
        return $users;
    }

    /**
     * Summary of changePassword
     * @param $request
     */
    public function changePassword($request)
    {
        return User::where('id', '=', $request['id'])->update(['password' => Hash::make($request['confirm_password'])]);
    }
}
