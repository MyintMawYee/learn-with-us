<?php
namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;

class UserService implements UserServiceInterface {
  private $userDao;

  /**
   * Summary of __construct
   * @param UserDaoInterface $userDaoInterface
   */
  
  public function __construct(UserDaoInterface $userDaoInterface)
  {
    $this->userDao = $userDaoInterface;
  }

  /**
   * Summary of login
   * @param mixed $validated
   * @return array|bool
   */

  public function login($validated)
  {
    return $this->userDao->login($validated);
  }

   /**
   * Summary of register
   * @param mixed $validated
   */

  public function register($validated)
  {
    return $this->userDao->register($validated);
  }

}