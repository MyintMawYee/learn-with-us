<?php

namespace App\Services\Course;

use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Contracts\Services\Course\CourseServiceInterface;

class CourseService implements CourseServiceInterface
{
    private $courseService;

    /**
     * Summary of __construct
     * @param CourseDaoInterface $courseDaoInterface
     */
    public function __construct(CourseDaoInterface $courseDaoInterface)
    {
        $this->courseService = $courseDaoInterface;
    }

    /**
     * Summary of create
     * @param mixed $validated
     * @return string
     */
    public function create($validated)
    {
        return $this->courseService->create($validated);
    }

    /**
     * Summary of edit
     * @param mixed $id
     * @return array|bool
     */
    public function edit($id)
    {
        return $this->courseService->edit($id);
    }

    /**
     * Summary of update
     * @param mixed $validated
     * @param mixed $id
     * @return string
     */
    public function update($validated, $id)
    {
        return $this->courseService->update($validated, $id);
    }
    
}
