<?php
namespace App\Contracts\Dao\CourseVideo;
interface CourseVideoDaoInterface {

  /**
   * Summary of createVideo
   * @param mixed $id
   * @param mixed $path
   * @return void
   */
  public function createVideo($id,$path);

}