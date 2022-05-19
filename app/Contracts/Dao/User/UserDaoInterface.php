<?php
namespace App\Contracts\Dao\User;
interface UserDaoInterface {
  public function register($validated);
  public function login($validated);
}