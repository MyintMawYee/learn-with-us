<?php
namespace App\Dao\User;
use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDao implements UserDaoInterface {
  
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
  
}