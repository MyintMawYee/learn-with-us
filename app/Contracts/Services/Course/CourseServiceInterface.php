<?php

namespace App\Contracts\Services\Course;

use Illuminate\Http\Request;

interface CourseServiceInterface
{
    /**
     * Summary of create
     * @param mixed $validated
     * @return void
     */
    public function create(Request $request);

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
    public function update(Request $request, $id);

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
     * Summary of tmpFileStore
     * @param mixed $validated
     * @return void
     */
    public function tmpFileStore($validated);

}
