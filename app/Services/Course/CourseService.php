<?php

namespace App\Services\Course;

use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Contracts\Dao\CourseVideo\CourseVideoDaoInterface;
use App\Contracts\Services\Course\CourseServiceInterface;
use Illuminate\Http\Request;
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
            $path = rand(0, 99) . $courseVd;
                Storage::disk('public')->put(
                    "coursevideo/" . $path,
                    "tmp_video/" . $courseVd
                );
            Storage::disk('public')->delete("tmp_video/".$courseVd);
            $this->courseVideoService->createVideo($id,$path);
        }
        return;
    }

    /**
     * Summary of create
     * @param mixed $validated
     * @return string
     */
    public function create(Request $request)
    {
        $courseImage = rand(0,99).$request->course_cover_path;
            $storageCover = Storage::disk('public')->put(
                "courseimg/" .$courseImage,
                "tmp_img/" . $request->course_cover_path
            );
        Storage::disk('public')->delete("tmp_img/" . $request->course_cover_path);
        $request->course_cover_path = $courseImage;
        $addedCourse = $this->courseService->create($request);
        if (!$addedCourse) {
            Storage::disk('public')->delete("courseimg/".$courseImage);
            return "Sorry, course couldn't add.";
        }
        $this->loopVideo($request->video_path,$addedCourse->id);
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
    public function update(Request $request, $id)
    {
        $currentCourse = $this->courseService->edit($id);
        if ($currentCourse) {
            $currentCover = $currentCourse->course_cover_path;
            $incomeCover = $request->course_cover_path;
            $newCover = rand(0,99).$incomeCover;
            Storage::disk('public')->put(
                "courseimg/". $newCover,
                "tmp_img/" . $incomeCover
            );
            Storage::disk('public')->delete("tmp_img/" . $incomeCover);
            $request->course_cover_path = $newCover;
            $updated = $this->courseService->update($currentCourse,$request);
            if ($updated) {
                Storage::disk('public')->delete("courseimg/".$currentCover);
                $this->loopVideo($request->video_path,$currentCourse->id);
                foreach ($currentCourse->video as $cVideo) {
                    $existPath = $cVideo->path;
                    Storage::disk('public')->delete('coursevideo/' . $existPath);
                }
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

    /**
     * Summary of tmpFileStore
     * @param mixed $validated
     * @return array
     */
    public function tmpFileStore($validated)
    {
        $tmpImg = "http://127.0.0.1:8000/storage/tmp_img/";
        $tmpVideo = "http://127.0.0.1:8000/storage/tmp_video/";
        $imgPath = rand(0,99999) . $validated['course_cover_path']->getClientOriginalName();
        Storage::disk('public')->put("tmp_img/".$imgPath,
        file_get_contents($validated['course_cover_path']));
        foreach($validated['video_path'] as $video) {
            $videoPath = rand(0, 99999) . $video->getClientOriginalName();
            $vPath["video_path"] = $videoPath;
            $vPath["video_link"] = $tmpVideo.$videoPath;
            Storage::disk('public')->put('tmp_video/' . $videoPath, file_get_contents($video));
        }
        return [
            "name" => $validated['name'],
            "course_cover_path" => $imgPath,
            "course_cover_link" => $tmpImg.$imgPath,
            "video" => $vPath,
            "category_id" => $validated['category_id'],
            "short_descrip" => $validated["short_descrip"],
            "description" => $validated['description'],
            "instructor" => $validated['instructor'],
            "price" => $validated['price'],
        ];
    }
}
