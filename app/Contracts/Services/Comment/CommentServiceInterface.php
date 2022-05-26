<?php

namespace App\Contracts\Services\Comment;
interface CommentServiceInterface {

  /**
   * Summary of create
   * @return void
   */
  public function create($validated);

  /**
   * Summary of get
   * @return void
   */
  public function get($course_id);

  /**
   * Summary of delete
   * @return void
   */
  public function delete($id);

  /**
   * Summary of edit
   * @return void
   */
  public function getByID($id);

  /**
   * Summary of update
   * @return void
   */
  public function update($id,$validated);
  
}