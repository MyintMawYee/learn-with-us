<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Services\Course\CourseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSubmitRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    private $courseService;

    /**
     * Summary of __construct
     * @param CourseServiceInterface $courseServiceInterface
     */
    public function __construct(CourseServiceInterface $courseServiceInterface)
    {
        $this->courseService = $courseServiceInterface;
    }

    /**
     * Summary of createCourse
     * @param CourseSubmitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCourse(CourseSubmitRequest $request)
    {
        $validated = $request->validated();
        $status = $this->courseService->create($validated);
        if (!$status) {
            return response()->json([
                'result' => 0,
                'message' => "Sorry, Course couldn't add.",
            ], 401);
        }
        return response()->json([
            'result' => 1,
            'message' => 'Course has been added successfully'
        ], 200);
    }

    /**
     * Display a listing of the Courses
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCourse()
    {
        $courses = $this->courseService->getAll();
        return response()->json($courses, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCourse($id)
    {
        $course = $this->courseService->deleteCourse($id);
        $img_path = trim($course->course_cover_path, "/");
        unlink($img_path);
        $video_path = trim($course->video_path, "/");
        unlink($video_path);
        return response()->json([
            'result' => 1,
            'message' => 'Course has been deleted successfully'
        ], 200);
    }
}
