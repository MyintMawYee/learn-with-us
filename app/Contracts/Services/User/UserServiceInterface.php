<?php

namespace App\Contracts\Services\User;

interface UserServiceInterface {
  public function register($validated);
  public function login($validated);
}