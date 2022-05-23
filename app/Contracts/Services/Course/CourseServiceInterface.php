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
}
