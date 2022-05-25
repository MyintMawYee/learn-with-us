<?php

namespace App\Contracts\Dao\Course;

interface CourseDaoInterface
{
    /**
     * Summary of create
     * @param mixed $validated
     * @return Object
     */
    public function create($validated);

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
    public function update($object, $validated);

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
}
