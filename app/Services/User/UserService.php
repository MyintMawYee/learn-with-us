<?php
namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

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

   /**
   * Summary of logout
   * @param Request $request
   * @return string
   */
  public function logout(Request $request)
  {
      return $this->userDao->logout($request);
  }
  
   /**
   * Summary of confirm register
   * @param mixed $validated
   */
  public function registerconfirm($validated)
  {
      return $this->userDao->registerconfirm($validated);
  }
  
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function getAllUser()
  {
      return $this->userDao->getAllUser();
  }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function show($id)
  {
    $users= $this->userDao->show($id);
    if ($users)
     {
      return [
        'result' => 1,
        'message' => 'User lists'
      ];
     }
     return [
      'result' => 0,
      'message' => 'failed'
    ];
  }

    /**
     * Summary of disable users
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
  public function disableUser($id) 
  {
     $users= $this->userDao->disableUser($id);
     if ($users)
     {
      return [
        'result' => 1,
        'message' => 'success'
      ];
     }
     return [
      'result' => 0,
      'message' => 'failed'
    ];
    }
  }
