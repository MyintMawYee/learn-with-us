<?php

namespace App\Http\Controllers\Comment;

use App\Contracts\Services\Comment\CommentServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Services\Comment\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    private $commentService;

    /**
     * Summary of __construct
     * @param CommentServiceInterface $commentServiceInterface
     */
    public function __construct(CommentServiceInterface $commentServiceInterface)
    {
        $this->commentService = $commentServiceInterface;
    }

    /**
     * Summary of createComment
     * @param CommentRequest $request
     * @return mixed
     */
    public function createComment(CommentRequest $request) {
        $validated = $request->validated();
        $data = $this->commentService->create($validated);
        return response()->json($data,200);
    }

    /**
     * Summary of getcommentCourse
     * @param mixed $id
     * @return mixed
     */
    public function getcommentCourse($id) {
        $data = $this->commentService->get($id);
        if ($data) {
            return response()->json([
                "result" => 1,
                "message" => "All comment for course_id (" . $id . ")",
                "data" => $data
            ]);
        }
        return response()->json([
            "result" => 1,
            "message" => "Comment fetching failed."
        ]);
        
    }

    /**
     * Summary of deleteCommentID
     * @param mixed $id
     * @return mixed
     */
    public function deleteCommentID($id) {
        $data = $this->commentService->delete($id);
        return response()->json($data);
    }

    /**
     * Summary of getCommentID
     * @param mixed $id
     * @return mixed
     */
    public function getCommentID($id) {
        $data = $this->commentService->getByID($id);
        return response()->json($data);
    }

    /**
     * Summary of updateComment
     * @param mixed $id
     * @param Request $request
     * @return mixed
     */
    public function updateComment($id,Request $request) {
        $validated = $request->validate(
        ["content" => "required"],
        );
        $status = $this->commentService->update($id, $validated);
        return response()->json($status);
    }
    
}
