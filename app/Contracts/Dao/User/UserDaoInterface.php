<?php
namespace App\Contracts\Dao\User;
use Illuminate\Http\Request;
interface UserDaoInterface {

  /**
   * Summary of login
   * @param mixed $validated
   * @return array|bool
   */
  public function login($validated);

  /**
   * Summary of register
   * @param mixed $validated
   * @return void
   */
  public function register($validated);

  /**
   * Summary of logout
   * @param Request $request
   * @return void
   */
  public function logout(Request $request);

}