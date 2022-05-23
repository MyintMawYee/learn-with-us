<?php

namespace App\Dao\Course;

use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Support\Facades\Storage;

class CourseDao implements CourseDaoInterface
{
    /**
     * Summary of createVideo
     * @param mixed $validated
     * @param mixed $id
     * @return void
     */
    private function createVideo($validated, $id)
    {
        foreach ($validated as $courseVd) {
            $path = $courseVd->getClientOriginalName();
            if (!Storage::disk('public')->exists("coursevideo/" . $path)) {
                Storage::disk('public')->put(
                    "coursevideo/" . $path,
                    file_get_contents($courseVd)
                );
            }
            CourseVideo::create([
                'path' => $path,
                'course_id' => $id,
            ]);
        }
        return true;
    }

    /**
     * Summary of create
     * @param mixed $validated
     * @return string
     */
    public function create($validated)
    {
        $courseImage = $validated['course_cover_path']->getClientOriginalName();
        if (Storage::disk('public')->exists("courseimg/" . $courseImage)) {
            return "Your cover photo is already exist";
        }
        $course = Course::create([
            'name' => $validated['name'],
            'course_cover_path' => $courseImage,
            'category_id' => $validated['category_id'],
            'short_descrip' => $validated['short_descrip'],
            'description' => $validated['description'],
            'instructor' => $validated['instructor'],
            'price' => $validated['price']
        ]);
        if (!$course) {
            return "Sorry, course couldn't add.";
        }
        Storage::disk('public')->put(
            "courseimg/" . $courseImage,
            file_get_contents($validated['course_cover_path'])
        );
        $this->createVideo($validated['video_path'], $course->id);
        return "Course had been added successfully.";
    }

    /**
     * Summary of edit
     * @param mixed $id
     * @return array|bool
     */
    public function edit($id)
    {
        $imgPath = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/storage/courseimg/";
        $videoPath = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/storage/coursevideo/";
        $editData = Course::find($id);
        $finalData = [];
        if ($editData) {
            foreach ($editData->video as $video) {
                $data["id"] = $video->id;
                $data["video_name"] = $video->path;
                $data["video_path"] = $videoPath . $video->path;
                $finalData[] = $data;
            }
            return [
                "id" => $editData->id,
                "name" => $editData->name,
                "cover_name" => $editData->course_cover_path,
                "cover_path" => $imgPath . $editData->course_cover_path,
                "category_id" => $editData->category_id,
                "short_descrip" => $editData->short_descrip,
                "description" => $editData->description,
                "instructor" => $editData->instructor,
                "price" => $editData->price,
                "video" => $finalData,
                "created_date" => $editData->created_at,
                "updated_date" => $editData->updated_at
            ];
        } else {
            return false;
        }
    }

    /**
     * Summary of update
     * @param mixed $validated
     * @param mixed $id
     * @return string
     */
    public function update($validated, $id)
    {
        $currentCourse = Course::find($id);
        if ($currentCourse) {
            $currentCover = $currentCourse['course_cover_path'];
            $incomeCover = $validated['course_cover_path']->getClientOriginalName();
            if (Storage::disk('public')->exists("courseimg/" . $incomeCover)) {
                if ($currentCover != $incomeCover) {
                    return "Your image is already exist in another course. Please use different one.";
                }
            } else {
                if (Storage::disk('public')->delete("courseimg/" . $currentCover)) {
                    Storage::disk('public')->put(
                        "courseimg/" . $incomeCover,
                        file_get_contents($validated['course_cover_path'])
                    );
                }
            }
            $currentCourse->name = $validated['name'];
            $currentCourse->course_cover_path = $incomeCover;
            $currentCourse->category_id = $validated['category_id'];
            $currentCourse->short_descrip = $validated['short_descrip'];
            $currentCourse->description = $validated['description'];
            $currentCourse->instructor = $validated['instructor'];
            $currentCourse->price = $validated['price'];
            foreach ($currentCourse->video as $cVideo) {
                $existPath = $cVideo->path;
                $courseVideo = CourseVideo::where([
                    ["path", "=", $existPath],
                    ["course_id", "!=", $id]
                ])->get();
                if (!$courseVideo) {
                    Storage::disk('public')
                        ->delete("coursevideo/" . $existPath);
                }
            }
            $currentCourse->video()->delete();
            $currentCourse->save();
            $this->createVideo($validated['video_path'], $id);
            return "Course has been updated.";
        } else {
            return "ID." . $id . " is not found";
        }
    }
    
}
