<?php
namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;

class UserService implements UserServiceInterface {
  private $userDao;
  public function __construct(UserDaoInterface $userDaoInterface)
  {
    $this->userDao = $userDaoInterface;
  }

  public function register($validated)
  {
    
  }

  public function login($validated)
  {
    
  }

}