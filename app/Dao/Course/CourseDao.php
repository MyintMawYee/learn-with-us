<?php

namespace App\Dao\Course;

use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Category;

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
    public function update($object, Request $request)
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

    /**
     * Summary of getCourseMayLike
     * @param mixed $id
     * @return Object
     */
    public function getCourseMayLike($id)
    {
        return Course::where("category_id", $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    /**
     * Count all Courses
     *
     * @return \Illuminate\Http\Response
     */
    public function countCourse()
    {
        $courses = Course::all()->count();
        return $courses;
    }

    public function getTopCourse()
    {
        $free = Course::where('price', '!=', 0)
            ->orderBy('price', 'DESC')
            ->limit(12)
            ->get();
        return $free;
    }

     /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function buyCourse(Request $request)
    {
        $data = $request->$course_id;
        $data = $request->$course_cover_path;
        Course::insert($data);
        $data = $request->$user_id;
        User::insert($data);
        return $data;
    }
}
