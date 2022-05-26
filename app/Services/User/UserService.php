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
  public function index()
  {
      return $this->userDao->User::all();
  }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function show($id)
  {
      return $this->userDao->User::all();
  }

    /**
     * Summary of disable users
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
  public function disable_user($id) 
  {
     return $this->userDao->disable_user($id);
  }
}
