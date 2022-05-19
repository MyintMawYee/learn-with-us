<?php
namespace App\Contracts\Dao\User;
interface UserDaoInterface {

  /**
   * Summary of login
   * @param mixed $validated
   * @return array|bool
   */
  
  public function login($validated);
}