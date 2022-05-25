<?php

namespace App\Contracts\Services\User;
use Illuminate\Http\Request;
interface UserServiceInterface {

  /**
   * Summary of login
   * @param mixed $validated
   * @return array|bool
   */
  
  public function login($validated);

  /**
   * Summary of register
   * @param mixed $validated
  */
  public function register($validated);

  /**
   * Summary of logout
   * @param Request $request
   * @return void
   */
  public function logout(Request $request);
  
}