<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Services\Course\CourseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSubmitRequest;
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

    public function createCourse(CourseSubmitRequest $request) {
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

}
