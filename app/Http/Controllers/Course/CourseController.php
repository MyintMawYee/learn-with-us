<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Services\Course\CourseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSubmitRequest;
use App\Http\Requests\CourseUpdateRequest;
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
        $data = $this->courseService->createCheck($validated);
        return response()->json([
            "result" => 0,
            "message" => "Validation Succeess",
            "data" => $data,
        ]);
    }

    /**
     * Summary of updateCourse
     * @param CourseSubmitRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCourse(CourseUpdateRequest $request,$id)
    {
        $validated = $request->validated();
        $data = $this->courseService->updateCheck($validated,$id);
        return response()->json([
            "result" => 0,
            "message" => "Validation Succeess",
            "data" => [
                "id" => $id,
                "course" => $data
            ]
        ]);
    }

    /**
     * Summary of editCourse
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailCourse($id)
    {
        $editCourse = $this->courseService->edit($id);
        if (!$editCourse) {
            return response()->json([
                'result' => 1,
                'message' => "ID." . $id . " is not found",
            ]);
        }
        return response()->json([
            'result' => 1,
            'message' => "Edit Course has been fetch",
            'data' => $editCourse
        ]);
    }

    /**
     * Summary of confirmCreate
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createConfirm(Request $request) {
        $create = $this->courseService->create($request);
        return response()->json([
            "result" => 1,
            "message" => $create,
        ]);
    }

    /**
     * Summary of updateCourse
     * @param CourseSubmitRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateConfirm(Request $request, $id)
    {
        $update = $this->courseService->update($request, $id);
        return response()->json([
            'result' => 1,
            'message' => $update,
        ]);
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
        Storage::disk('public')->delete("courseimg/" . $course->course_cover_path);
        Storage::disk('public')->delete("coursevideo/" . $course->video_path);
        return response()->json([
            'result' => 0,
            'message' => 'Course has been deleted successfully'
        ], 200);
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  string  $param
     * @return \Illuminate\Http\Response
     */
    public function searchCourse($param)
    {
        $courses = $this->courseService->searchCourse($param);
        return response()->json([
            'result' => 1,
            'message' => "Search is completely finished",
            'data' => $courses
        ]);
    }

    /**
     * Summary of getCoureMayLike
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function getCoureMayLike($id) {
        $data = $this->courseService->getCourseMayLike($id);
        return response()->json($data);
    }

    /**
     * Summary of freeCourse
     * @return void
     */
    public function getTopCourse() {
        $free = $this->courseService->getTopCourse();
        return response()->json($free);
    }

    /**
     * Summary of getCourse
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function getMyCourse($id) 
    {
        $myCourse = $this->courseService->getMyCourse($id);
        return response()->json($myCourse);
    }
}

