<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Services\Course\CourseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSubmitRequest;
use App\Http\Requests\CourseUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

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
        return response()->json($data);
    }

    /**
     * Summary of updateCourse
     * @param CourseSubmitRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCourse(CourseUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->courseService->updateCheck($validated,$id);
        return response()->json($data);
    }

    /**
     * Summary of editCourse
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailCourse($id)
    {
        $editCourse = $this->courseService->edit($id);
        return response()->json($editCourse);
    }

    /**
     * Summary of confirmCreate
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createConfirm(Request $request)
    {
        $create = $this->courseService->create($request);
        return response()->json($create);
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
        return response()->json($update);
    }

    /**
     * Summary of getAllCourse
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCourse()
    {
        $courses = $this->courseService->getAll();
        return response()->json($courses, 200);
    }

    /**
     * Summary of deleteCourse
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
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
     * Summary of searchCourse
     * @param string $param
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCoureMayLike($id)
    {
        $data = $this->courseService->getCourseMayLike($id);
        return response()->json($data);
    }

    /**
     * Summary of getTopCourse
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopCourse() {
        $free = $this->courseService->getTopCourse();
        return response()->json($free);
    }

    /**
     * Summary of cancelCourse
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelCourse() {
        $cancel = $this->courseService->cancelCourse();
        return response()->json($cancel);
    }

    public function getCurrentData() {
        $currentData = $this->courseService->getCurrentData();
        return response()->json($currentData);
    } 

    /**
     * Summary of getMyCourse
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyCourse($id) 
    {
        $myCourse = $this->courseService->getMyCourse($id);
        return response()->json([
            'result' => 1,
            'message' => 'Your Course',
            'data' => $myCourse
        ]);
    }

    /**
     * Summary of countCourse
     * @return \Illuminate\Http\JsonResponse
     */
    public function countCourse()
    {
        $courses = $this->courseService->countCourse();
        return response()->json([
            'result' => 1,
            'data' => $courses
        ]);
    }

     /**
     * Summary of buyCourse
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyCourse(Request $request)
    {
        $courses = $this->courseService->buyCourse($request);
        $this->mailsend();
        return response()->json([
            'result' => 1,
            'message' =>'success',
            'data' => 'success'
        ]);
    }

    /** 
     * To send mail 
     * @return boolean
     */
    public function mailsend()
    {
        $details = [
            'title' => 'Title: Course',
            'body' => 'Body: Your purchase is success'
        ];
        Mail::to('shwephue7889@gmail.com')->send(new SendMail($details));
        return true;
    }
}
