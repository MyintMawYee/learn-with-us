<?php

namespace App\Contracts\Services\User;

use Illuminate\Http\Request;

interface UserServiceInterface {

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

  /**
   * Summary of logout
   * @param Request $request
   * @return void
   */
  public function logout(Request $request);

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUser();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id);

    /**
     * Summary of confirmRegister
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerConfirm($validated);

    /**
     * Summary of disable users
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function disableUser($id);

    /**
   * Summary of changePassword
   * @param mixed $request
   * @return array
   */
    public function changePassword($request);
}
