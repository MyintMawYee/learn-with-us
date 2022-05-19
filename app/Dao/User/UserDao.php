<?php
namespace App\Dao\User;
use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDao implements UserDaoInterface {
  public function register($validated)
  {
    
  }
  public function login($validated)
  {
    if (!Auth::attempt($validated)) {
      return false;
  }
    $user = User::where('email', $validated['email'])->first();
    $data['token'] = $user->createToken('myToken')->accessToken;
    $data['name'] = $user->name;
    $data['type'] = $user->type;
    $data['disable'] = $user->disable;
    return $data;
    
  }
}