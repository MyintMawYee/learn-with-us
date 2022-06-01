<?php

namespace App\Services\Course;

session_start();

use App\Contracts\Dao\Course\CourseDaoInterface;
use App\Contracts\Dao\CourseVideo\CourseVideoDaoInterface;
use App\Contracts\Services\Course\CourseServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

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
     * Summary of deleteCurrentSession
     * @param mixed $session
     * @return void
     */
    private function deleteCurrentSession($session)
    {
        if (Storage::disk('public')->exists("tmp_img/" . $session['course_cover_path'] ?? "")) {
            Storage::disk('public')->delete("tmp_img/" . $session['course_cover_path'] ?? "");
        }
        foreach ($session['video'] as $video) {
            $videoPath = $video['video_path'];
            if (Storage::disk('public')->exists("tmp_video/" . $videoPath)) {
                Storage::disk('public')->delete("tmp_video/" . $videoPath);
            }
        }
        return;
    }

    /**
     * Summary of create
     * @param mixed $validated
     * @return string
     */
    public function create($request)
    {
        $courseImage = rand(0, 99) . $request->course_cover_path;
        Storage::disk('public')->move(
            "tmp_img/" . $request->course_cover_path,
            "courseimg/" . $courseImage
        );
        $request->course_cover_path = $courseImage;
        $addedCourse = $this->courseService->create($request);
        if (!$addedCourse) {
            Storage::disk('public')->delete("courseimg/" . $courseImage);
            return [
                "result" => intval(Lang::get("messages.result.fail")),
                "message" => Lang::get("messages.coursecreate.fail")
            ];
        }
        foreach ($request->video_path as $courseVd) {
            $path = rand(0, 99) . $courseVd;
            Storage::disk('public')->move(
                "tmp_video/" . $courseVd,
                "coursevideo/" . $path
            );
            $this->courseVideoService->createVideo($addedCourse->id, $path);
        }
        return [
            "result" => intval(Lang::get("messages.result.success")),
            "message" => Lang::get("messages.coursecreate.success")
        ];
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
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.courseedit.success"),
                "data" => [
                    "id" => $editData->id,
                    "name" => $editData->name,
                    "cover_name" => $editData->course_cover_path,
                    "cover_path" => $imgPath . $editData->course_cover_path,
                    "category" => [
                        "id" => $editData->category->id,
                        "name" => $editData->category->name
                    ],
                    "short_descrip" => $editData->short_descrip,
                    "description" => $editData->description,
                    "instructor" => $editData->instructor,
                    "price" => $editData->price,
                    "video" => $finalData,
                    "created_date" => $editData->created_at,
                    "updated_date" => $editData->updated_at
                ]
            ];
        } else {
            return [
                "result" => intval(Lang::get("messages.result.fail")),
                "message" => Lang::get("messages.courseedit.notfound")
            ];
        }
    }

    /**
     * Summary of update
     * @param mixed $request
     * @param mixed $id
     * @return string
     */
    public function update($request, $id)
    {
        $currentCourse = $this->courseService->edit($id);
        if ($currentCourse) {
            $currentCover = $currentCourse->course_cover_path;
            $incomeCover = $request->course_cover_path;
            if ($currentCover != $incomeCover) {
                $newCover = rand(0, 99) . $incomeCover;
                Storage::disk('public')->move(
                    "tmp_img/" . $incomeCover,
                    "courseimg/" . $newCover
                );
                Storage::disk('public')->delete("courseimg/" . $currentCover);
                $request->course_cover_path = $newCover;
            }
            foreach ($request->video_path as $courseVd) {
                if (!Storage::disk('public')->exists("coursevideo/" . $courseVd)) {
                    foreach ($currentCourse->video as $cVideo) {
                        if (Storage::disk('public')->exists("coursevideo/" . $cVideo)) {
                            Storage::disk('public')->delete("coursevideo/" . $cVideo);
                        }
                    }
                }
            }
            $updated = $this->courseService->update($currentCourse, $request);
            if ($updated) {
                foreach ($request->video_path as $nvPath) {
                    if (Storage::disk('public')->exists("coursevideo/" . $nvPath)) {
                        $this->courseVideoService->createVideo($id, $nvPath);
                    } else {
                        $newPath = rand(0, 99) . $nvPath;
                        Storage::disk('public')->move(
                            "tmp_video/" . $nvPath,
                            "coursevideo/" . $newPath
                        );
                        $this->courseVideoService->createVideo($id, $newPath);
                    }
                }
                return [
                    "result" => intval(Lang::get("messages.result.success")),
                    "message" => Lang::get("messages.courseupdate.success")
                ];
            }
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.courseupdate.notfound")
        ];
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
     * @return string
     */
    public function createCheck($validated)
    {
        $tmpImg = "http://127.0.0.1:8000/storage/tmp_img/";
        $tmpVideo = "http://127.0.0.1:8000/storage/tmp_video/";
        $imgPath = rand(0, 99999) . $validated['course_cover_path']->getClientOriginalName();
        Storage::disk('public')->put(
            "tmp_img/" . $imgPath,
            file_get_contents($validated['course_cover_path'])
        );
        foreach ($validated['video_path'] as $video) {
            $videoPath = rand(0, 99999) . $video->getClientOriginalName();
            $vPath["video_path"] = $videoPath;
            $vPath["video_link"] = $tmpVideo . $videoPath;
            $vData[] = $vPath;
            Storage::disk('public')->put('tmp_video/' . $videoPath, file_get_contents($video));
        }
        $courseData = [
            "name" => $validated['name'],
            "course_cover_path" => $imgPath,
            "course_cover_link" =>  $tmpImg . $imgPath,
            "video" => $vData,
            "category_id" => $validated['category_id'],
            "short_descrip" => $validated["short_descrip"],
            "description" => $validated['description'],
            "instructor" => $validated['instructor'],
            "price" => $validated['price']
        ];
        $courseCreater = Auth::guard('api')->user()->id;
        if (isset($_SESSION['course_data' . $courseCreater])) {
            $this->deleteCurrentSession($_SESSION['course_data' . $courseCreater]);
        }
        $_SESSION['course_data' . $courseCreater] = $courseData;
        return [
            "result" => intval(Lang::get("messages.result.success")),
            "message" => Lang::get("messages.validation.success")
        ];
    }

    /**
     * Summary of updateCheck
     * @param mixed $validated
     * @param mixed $id
     * @return string
     */
    public function updateCheck($validated, $id)
    {
        $tmpImg = "http://127.0.0.1:8000/storage/tmp_img/";
        $tmpVideo = "http://127.0.0.1:8000/storage/tmp_video/";
        $imgFolder = "http://127.0.0.1:8000/storage/courseimg/";
        $videoFolder = "http://127.0.0.1:8000/storage/coursevideo/";
        $currentCourse = $this->courseService->edit($id);
        if (isset($validated['course_cover_path'])) {
            $imgPath = rand(0, 99999) . $validated['course_cover_path']->getClientOriginalName();
            $imgLink = $tmpImg . $imgPath;
            Storage::disk('public')->put(
                "tmp_img/" . $imgPath,
                file_get_contents($validated['course_cover_path'])
            );
        } else {
            $imgPath = $currentCourse->course_cover_path;
            $imgLink = $imgFolder . $imgPath;
        }

        if (isset($validated['video_path'])) {
            foreach ($validated['video_path'] as $video) {
                $videoPath = rand(0, 99999) . $video->getClientOriginalName();
                $vPath["video_path"] = $videoPath;
                $vPath["video_link"] = $tmpVideo . $videoPath;
                $vData[] = $vPath;
                Storage::disk('public')->put('tmp_video/' . $videoPath, file_get_contents($video));
            }
        } else {
            foreach ($currentCourse->video as $video) {
                $videPath = $video->path;
                $vPath["video_path"] = $videPath;
                $vPath["video_link"] = $videoFolder . $videPath;
                $vData[] = $vPath;
            }
        }
        $courseData = [
            "name" => $validated['name'],
            "course_cover_path" => $imgPath,
            "course_cover_link" => $imgLink,
            "video" => $vData,
            "category_id" => $validated['category_id'],
            "short_descrip" => $validated["short_descrip"],
            "description" => $validated['description'],
            "instructor" => $validated['instructor'],
            "price" => $validated['price']
        ];
        $courseCreater = Auth::guard('api')->user()->id;
        if (isset($_SESSION['course_data' . $courseCreater])) {
            $this->deleteCurrentSession($_SESSION['course_data' . $courseCreater]);
        }
        $_SESSION['course_data' . $courseCreater] = $courseData;
        return [
            "result" => intval(Lang::get("messages.validation.success")),
            "message" => Lang::get("messages.validation.success"),
        ];
    }

    /** Search the specified resource from storage.
     * @param  $param
     * @return \Illuminate\Http\Response
     */
    public function searchCourse($param)
    {
        $imgPath = "http://127.0.0.1:8000/storage/courseimg/";
        $fcourse = $this->courseService->searchCourse($param);
        if ($fcourse) {

            foreach ($fcourse as $course) {
                $filter['id'] = $course->id;
                $filter['name'] = $course->name;
                $filter['course_cover_path'] = $course->course_cover_path;
                $filter['course_cover_link'] = $imgPath . $course->course_cover_path;
                $filter['category_id'] = $course->category_id;
                $filter["short_descrip"] = $course->short_descrip;
                $filter["description"] = $course->description;
                $filter["instructor"] = $course->instructor;
                $filter["price"] = $course->price;
                $finalData[] = $filter;
            }
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.searchdata.found"),
                "data" => $finalData,
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.topcourse.notfound")
        ];
    }

    /**
     * Count all Courses
     *
     * @return \Illuminate\Http\Response
     */
    public function countCourse()
    {
        return $this->courseService->countCourse();
    }

    /**
     * Summary of getCourseMayLike
     * @param mixed $id
     * @return array
     */
    public function getCourseMayLike($id)
    {
        $imgPath = "http://127.0.0.1:8000/storage/courseimg/";
        $data = $this->courseService->getCourseMayLike($id);
        if ($data) {
            foreach ($data as $filter) {
                $finalData["id"] = $filter->id;
                $finalData['name'] = $filter->name;
                $finalData['course_cover_path'] = $filter->course_cover_path;
                $finalData['course_cover_link'] = $imgPath . $filter->course_cover_path;
                $finalData['category_id'] = $filter->category_id;
                $finalData["short_descrip"] = $filter->short_descrip;
                $finalData["decription"] = $filter->description;
                $finalData["instructor"] = $filter->instructor;
                $finalData["price"] = $filter->price;
                $filterData[] = $finalData;
            }
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.coursemaylike.found"),
                "data" => $filterData
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.coursemaylike.notfound")
        ];
    }

    public function getTopCourse()
    {
        $imgPath = "http://127.0.0.1:8000/storage/courseimg/";
        $fcourse = $this->courseService->getTopCourse();
        if (!isEmpty($fcourse)) {
            foreach ($fcourse as $course) {
                $filter["id"] = $course->id;
                $filter['course_cover_path'] = $course->course_cover_path;
                $filter['course_cover_link'] = $imgPath . $course->course_cover_path;
                $filter['category_id'] = $course->category_id;
                $filter["short_descrip"] = $course->short_descrip;
                $filter["description"] = $course->description;
                $filter["instructor"] = $course->instructor;
                $filter["price"] = $course->price;
                $finalData[] = $filter;
            }
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.topcourse.found"),
                "data" => $finalData
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.topcourse.notfound")
        ];
    }

    /**
     * Summary of getCurrentData
     * @return mixed
     */
    public function getCurrentData()
    {
        $requestID = Auth::guard('api')->user()->id;
        if (isset($_SESSION['course_data' . $requestID])) {
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.coursecurrentdata.exist"),
                "data" => $_SESSION['course_data' . $requestID]
            ];
        }
        return [
            "result" => intval(Lang::get("messages.coursecurrentdata.notexist")),
            "message" => Lang::get("messages.coursecurrentdata.notexist")
        ];;
    }

    /**
     * Summary of cancelCourse
     * @return array
     */
    public function cancelCourse()
    {
        $currentUser = Auth::guard('api')->user()->id;
        if (isset($_SESSION["course_data" . $currentUser])) {
            $imgPath = $_SESSION['course_data' . $currentUser]["course_cover_path"];
            if (Storage::disk('public')->exists('tmp_img/' . $imgPath)) {
                Storage::disk('public')->delete('tmp_img/' . $imgPath);
            }
            $videoPath = $_SESSION['course_data' . $currentUser]['video'];
            foreach ($videoPath as $video) {
                $singlePath = $video['video_path'];
                if (Storage::disk('public')->exists("tmp_video/" . $singlePath)) {
                    Storage::disk('public')->delete("tmp_video/" . $singlePath);
                }
            }
            unset($_SESSION["course_data" . $currentUser]);
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.coursedatacancel.success")
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.coursedatacancel.notfound")
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return $request
     */
    public function buyCourse($request)
    {
        return $this->courseService->buyCourse($request);
    }

    /** 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMyCourse($id)
    {
        return $myCourse = $this->courseService->getMyCourse($id);
    }
}
