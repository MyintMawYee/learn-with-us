<?php
namespace App\Contracts\Dao\User;

use Illuminate\Http\Request;

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
   * @return void
   */
  public function register($validated);

  /**
   * Summary of logout
   * @param Request $request
   * @return void
   */
  public function logout(Request $request);

   /**
   * Summary of confirm register
   * @param mixed $validated
   */
  public function registerconfirm($validated);

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function getAllUser();

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id);

    /**
     * Summary of disable users
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function disableUser($id);
}