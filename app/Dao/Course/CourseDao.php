<?php

namespace App\Dao\Course;

use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Models\Course;
use App\Models\Category;

class CourseDao implements CourseDaoInterface
{
    /**
     * Summary of create
     * @param mixed $validated
     * @return Object
     */
    public function create($validated)
    {
        $course = Course::create([
            'name' => $validated['name'],
            'course_cover_path' => $validated['course_cover_path'],
            'category_id' => $validated['category_id'],
            'short_descrip' => $validated['short_descrip'],
            'description' => $validated['description'],
            'instructor' => $validated['instructor'],
            'price' => $validated['price']
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
    public function update($object, $validated)
    {
        $object->name = $validated['name'];
        $object->course_cover_path = $validated["course_cover_path"];
        $object->category_id = $validated['category_id'];
        $object->short_descrip = $validated['short_descrip'];
        $object->description = $validated['description'];
        $object->instructor = $validated['instructor'];
        $object->price = $validated['price'];
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
        $courses = Course::with('category', 'video')->get();
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

    /**
     * Search the specified resource from storage.
     *
     * @param  $param
     * @return \Illuminate\Http\Response
     */
    public function searchCourse($param)
    {
        $categories = Category::all();

        $search_data = "%" . $param . "%";

        $courses = Course::where('instructor', 'like', $search_data)
            ->orWhere('price', 'like', $search_data)
            ->orWhereHas('category', function ($category) use ($search_data) {
                $category->where('name', 'like', $search_data);
            })->get();
        return $courses;
    }
}
