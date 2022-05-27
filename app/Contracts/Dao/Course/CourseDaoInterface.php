<?php

namespace App\Contracts\Dao\Course;

use Illuminate\Http\Request;

interface CourseDaoInterface
{
    /**
     * Summary of create
     * @param mixed $validated
     * @return Object
     */
    public function create(Request $request);

    /**
     * Summary of edit
     * @return Object
     */
    public function edit($id);

    /**
     * Summary of update
     * @param mixed $validated
     * @param mixed $id
     * @return void
     */
    public function update($object, Request $request);

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll();

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCourse($id);

    /**
     * Search the specified resource from storage.
     *
     * @param  $param
     * @return \Illuminate\Http\Response
     */
    public function searchCourse($param);

    /**
     * Summary of getCourseMayLike
     * @param mixed $id
     * @return Object
     */
    public function getCourseMayLike($id);

    /**
     * Count all Courses
     *
     * @return \Illuminate\Http\Response
     */
    public function countCourse();

    /**
     * Summary of freeCourse
     * @return Object
     */
    public function getTopCourse();

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMyCourse($id);

}
