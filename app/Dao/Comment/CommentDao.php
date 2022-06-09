<?php

namespace App\Dao\Comment;

use App\Contracts\Dao\Comment\CommentDaoInterface;
use App\Models\Comment;

class CommentDao implements CommentDaoInterface
{

    /**
     * Summary of create
     * @param mixed $validated
     * @return mixed
     */
    public function create($validated)
    {
        return Comment::create([
            "content" => $validated["content"],
            "user_id" => $validated["user_id"],
            "course_id" => $validated["course_id"]
        ]);
    }

    /**
     * Summary of get
     * @param mixed $course_id
     * @return Object
     */
    public function get($course_id)
    {
        return Comment::where("course_id", $course_id)
        ->orderBy("id", "DESC")->limit(7)
        ->get();
    }

    /**
     * Summary of getByID
     * @param mixed $id
     * @return mixed
     */
    public function getByID($id)
    {
        return Comment::find($id);
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param mixed $validated
     * @return mixed
     */
    public function update($id, $validated)
    {
        $existComment = Comment::find($id);
        $existComment->content = $validated["content"];
        return $existComment->save();
    }

    /**
     * Summary of delete
     * @param mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        return Comment::where("id", $id)->delete();
    }
    
}
