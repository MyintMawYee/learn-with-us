<?php

namespace App\Contracts\Services\User;

interface UserSericeInterface {
  public function register($validated);
  public function login($validated);
}