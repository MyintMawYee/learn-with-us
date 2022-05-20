<?php
namespace App\Dao\Course;
use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class CourseDao implements CourseDaoInterface {

  /**
   * Summary of create
   * @param mixed $validated
   * @return bool
   */
  public function create($validated)
  {
    $course = new Course();
    $courseImage = $validated['course_cover_path'];
    $courseVideo = $validated['video_path'];
    $imgUpload = $courseImage->store('courseimg','public'); 
    $imgPath = Storage::url($imgUpload);
    $videoUpload = $courseVideo->store('coursevideo','public');
    $videoPath = Storage::url($videoUpload);
    $course->name = $validated['name'];
    $course->course_cover_path = $imgPath;
    $course->video_path = $videoPath;
    $course->category_id = $validated['category_id'];
    $course->short_descrip = $validated['short_descrip'];
    $course->description = $validated['description'];
    $course->instructor = $validated['instructor'];
    $course->price = $validated['price'];
    $status = $course->save();
    return $status;
  }

}