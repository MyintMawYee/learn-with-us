<?php
namespace App\Dao\CourseVideo;
use App\Contracts\Dao\CourseVideo\CourseVideoDaoInterface;
use App\Models\CourseVideo;

class CourseVideoDao implements CourseVideoDaoInterface
{
    /**
     * Summary of createVideo
     * @param mixed $id
     * @param mixed $path
     * @return mixed
     */
    public function createVideo($id, $path)
    {
        $courseVideo = CourseVideo::create([
            'path' => $path,
            'course_id' => $id,
        ]);

        return $courseVideo;
    }

    public function exitVideo($id,$path) {
        $existVideo = CourseVideo::where([
            "id" => $id,
            "path" => $path
        ]);
        
        return $existVideo;
    }

}
