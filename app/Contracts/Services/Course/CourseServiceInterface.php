<?php

namespace App\Contracts\Services\Course;

interface CourseServiceInterface
{
    /**
     * Summary of create
     * @param mixed $validated
     * @return void
     */
    public function create($validated);

    /**
     * Summary of edit
     * @param mixed $id
     * @return void
     */
    public function edit($id);

    /**
     * Summary of update
     * @param mixed $validated
     * @param mixed $id
     * @return void
     */
    public function update($validated, $id);

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

    ///**
    // * Summary of tmpFileStore
    // * @param mixed $validated
    // * @return void
    // */
    //public function createCheck($validated);

    ///**
    // * Summary of updateCheck
    // * @param mixed $validated
    // * @param mixed $id
    // * @return void
    // */
    //public function updateCheck($validated,$id);
    
    /** Search the specified resource from storage.
     *
     * @param  $param
     * @return \Illuminate\Http\Response
     */
    public function searchCourse($param);

    /**
     * Summary of getCourseMayLike
     * @param mixed $id
     * @return void
     */
    public function getCourseMayLike($course_id);
    
    /**
     * Count all Courses
     *
     * @return \Illuminate\Http\Response
     */
    public function countCourse();

    /**
     * Summary of freeCourse
     * @return array
     */
    public function getTopCourse();

//    /**
//     * Summary of cancelCourse
//     * @return void
//     */
//    public function cancelCourse();
//
//    /**
//     * Summary of getCurrentData
//     * @return void
//     */
//    public function getCurrentData();
    
    /**
     * Summary of buy Course
     * @param $request
     */
    public function buyCourse($request);

     /**
     * Summary of getMyCourse
     * @param mixed $id
     * @return void
     */
    public function getMyCourse($id);
}
