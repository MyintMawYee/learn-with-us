<?php

namespace App\Dao\Course;

use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseDao implements CourseDaoInterface
{
    /**
     * Summary of create
     * @param mixed $validated
     * @return Object
     */
    public function create(Request $request)
    {
        $course = Course::create([
            'name' => $request->name,
            'course_cover_path' => $request->course_cover_path,
            'category_id' => $request->category_id,
            'short_descrip' => $request->short_descrip,
            'description' => $request->description,
            'instructor' => $request->instructor,
            'price' => $request->price
        ]);
        return $course;
    }

    /**
     * Summary of edit
     * @param mixed $id
     * @return Object
     */
    public function edit($id)
    {
        $editData = Course::find($id);
        return $editData;
    }

    /**
     * Summary of update
     * @param mixed $object
     * @param mixed $validated
     * @return mixed
     */
    public function update($object,Request $request)
    {
        $object->name = $request->name;
        $object->course_cover_path = $request->course_cover_path;
        $object->category_id = $request->category_id;
        $object->short_descrip = $request->short_descrip;
        $object->description = $request->description;
        $object->instructor = $request->instructor;
        $object->price = $request->price;
        $object->video()->delete();
        $object->save();
        return $object;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $courses = Course::all();
        return $courses;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCourse($id)
    {
        $course = Course::findOrfail($id);
        $course->delete();
        return $course;
    }

}
