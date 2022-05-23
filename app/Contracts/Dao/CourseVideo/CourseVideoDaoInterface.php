<?php
namespace App\Contracts\Dao\CourseVideo;
interface CourseVideoDaoInterface {
  public function createVideo($id,$path);
}