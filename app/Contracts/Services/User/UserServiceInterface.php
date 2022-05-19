<?php

namespace App\Contracts\Services\User;

interface UserServiceInterface {

  /**
   * Summary of login
   * @param mixed $validated
   * @return array|bool
   */
  
  public function login($validated);
  public function register($validated);
}

  