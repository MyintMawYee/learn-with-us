<?php
namespace App\Contracts\Dao\Course;
interface CourseDaoInterface {
  
  /**
   * Summary of create
   * @param mixed $validated
   * @return void
   */
  public function create($validated);
}