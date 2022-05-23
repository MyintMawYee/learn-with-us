<?php

namespace App\Services\Course;

use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Contracts\Dao\CourseVideo\CourseVideoDaoInterface;
use App\Contracts\Services\Course\CourseServiceInterface;
use App\Models\CourseVideo;
use Illuminate\Support\Facades\Storage;

class CourseService implements CourseServiceInterface
{
    private $courseService;
    private $courseVideoService;
    /**
     * Summary of __construct
     * @param CourseDaoInterface $courseDaoInterface
     */
    public function __construct(CourseDaoInterface $courseDaoInterface, CourseVideoDaoInterface $courseVideoDaoInterface)
    {
        $this->courseService = $courseDaoInterface;
        $this->courseVideoService = $courseVideoDaoInterface;
    }

    /**
     * Summary of loopVideo
     * @param mixed $pPath
     * @param mixed $id
     * @return void
     */
    private function loopVideo($pPath,$id) {
        foreach ($pPath as $courseVd) {
            $path = $courseVd->getClientOriginalName();
            if (!Storage::disk('public')->exists("coursevideo/" . $path)) {
                Storage::disk('public')->put(
                    "coursevideo/" . $path,
                    file_get_contents($courseVd)
                );
            }
            $this->courseVideoService->createVideo($id,$path);
        }
        return;
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
            $random = rand(0, 9999);
            $cover = $random.$courseImage;
            $storageCover = Storage::disk('public')->put(
                "courseimg/" .$cover,
                file_get_contents($validated['course_cover_path'])
            );
            if ($storageCover) {
                $validated['course_cover_path'] = $cover;
            }
        }
        else {
            Storage::disk('public')->put(
                "courseimg/" . $courseImage,
                file_get_contents($validated['course_cover_path'])
            );
            $validated['course_cover_path'] = $courseImage;
        }
        $addedCourse = $this->courseService->create($validated);
        if (!$addedCourse) {
            Storage::disk('public')->delete("courseimg/".$validated['course_cover_path']);
            return "Sorry, course couldn't add.";
        }
        $this->loopVideo($validated["video_path"],$addedCourse->id);
        return "Course has been created successfully.";
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
        $editData = $this->courseService->edit($id);
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
        $currentCourse = $this->courseService->edit($id);
        if ($currentCourse) {
            $currentCover = $currentCourse->course_cover_path;
            $incomeCover = $validated['course_cover_path']->getClientOriginalName();
            if (Storage::disk('public')->exists("courseimg/" . $incomeCover)) {
                if ($currentCover != $incomeCover) {
                    $random = rand(0, 9999);
                    $cover = $random . $incomeCover;
                    Storage::disk('public')->delete("courseimg/".$currentCover);
                    Storage::disk('public')->put(
                        "courseimg/" .$cover,
                        file_get_contents($validated['course_cover_path'])
                    );
                    $validated['course_cover_path'] = $cover;
                }
                else {
                    $validated['course_cover_path'] = $currentCover;
                }
            } else {
                if (Storage::disk('public')->delete("courseimg/" . $currentCover)) {
                    Storage::disk('public')->put(
                        "courseimg/" . $incomeCover,
                        file_get_contents($validated['course_cover_path'])
                    );
                }
                $validated['course_cover_path'] = $incomeCover;
            }
            $updated = $this->courseService->update($currentCourse,$validated);
            if ($updated) {
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
                $this->loopVideo($validated["video_path"],$currentCourse->id);
                return "Course has been updated successfully.";
            }
        }
        else {
            return "ID." . $id . " is not found";
        }
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getAll()
	{
		return $this->courseService->getAll();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function deleteCourse($id)
	{
		return $this->courseService->deleteCourse($id);
	}
}
