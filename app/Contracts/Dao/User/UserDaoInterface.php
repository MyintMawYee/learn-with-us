<?php
namespace App\Contracts\Dao\User;
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
   */
  public function register($validated);

  }