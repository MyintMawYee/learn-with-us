<?php

namespace App\Dao\Course;

use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\Purchase;

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
    public function update($id, $validated, $vdStatus)
    {
        $updateCourse = Course::find($id);
        $updateCourse->name = $validated["name"];
        $updateCourse->course_cover_path = $validated['course_cover_path'];
        $updateCourse->category_id = $validated['category_id'];
        $updateCourse->short_descrip = $validated['short_descrip'];
        $updateCourse->description = $validated['description'];
        $updateCourse->instructor = $validated['instructor'];
        $updateCourse->price = $validated['price'];
        if ($vdStatus == 1) {
            $updateCourse->video()->delete();
        }
        $updateCourse->save();
        return $updateCourse;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Object
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
     * @return Object
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
     * @param mixed $course_id
     * @return mixed
     */
    public function getCourseMayLike($course_id)
    {
        $currentCourse = Course::find($course_id);
        if ($currentCourse) {
            $currentCategory = $currentCourse->category->id;
            return Course::where("id", "!=", $course_id)
                ->where("category_id", $currentCategory)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        }
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

    /**
     * Summary of getTopCourse
     * @return Object
     */
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
     * @param $request
     */
    public function buyCourse($request)
    {
        return Purchase::insert([
            'user_id' => $request['user_id'],
            'course_id' => $request['course_id'],
        ]);
    }

    /**
     * Summary of show My course
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyCourse($id)
    {
        return User::select('courses.*', 'categories.name as category_name')
        ->join('purchases', 'purchases.user_id', 'users.id')
        ->join('courses', 'courses.id', 'purchases.course_id')
        ->join('categories', 'categories.id', 'courses.category_id')
        ->where('users.id', '=' ,$id)
        ->get();
    }
}
