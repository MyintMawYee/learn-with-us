<?php
namespace App\Contracts\Services\Course;
interface CourseServiceInterface {

  /**
   * Summary of create
   * @param mixed $validated
   * @return void
   */
  public function create($validated);

  /**
   * Summary of edit
   * @param mixed $id
   * @return void
   */
  public function edit($id);

  /**
   * Summary of update
   * @param mixed $validated
   * @param mixed $id
   * @return void
   */
  public function update($validated,$id);
  
}