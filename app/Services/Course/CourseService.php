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
	 * @return bool
	 */
	public function create($validated)
	{
		return $this->courseService->create($validated);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getAll()
	{
		return $this->courseService->getAll();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function deleteCourse($id)
	{
		return $this->courseService->deleteCourse($id);
	}
}
