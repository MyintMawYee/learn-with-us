<?php
namespace App\Contracts\Services\Course;
interface CourseServiceInterface {

  /**
   * Summary of create
   * @param mixed $validated
   * @return void
   */
  public function create($validated);
}