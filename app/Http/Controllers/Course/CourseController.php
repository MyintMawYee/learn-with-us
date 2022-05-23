<?php

namespace App\Http\Controllers\Course;

use App\Contracts\Services\Course\CourseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSubmitRequest;

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
        return response()->json([
            'result' => 0,
            'message' => $status,
        ], 401);
    }

    /**
     * Summary of editCourse
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCourse($id)
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
     * Summary of updateCourse
     * @param CourseSubmitRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCourse(CourseSubmitRequest $request, $id)
    {
        $validated = $request->validated();
        $update = $this->courseService->update($validated, $id);
        return response()->json([
            'result' => 1,
            'message' => $update,
        ]);
    }
    
}
