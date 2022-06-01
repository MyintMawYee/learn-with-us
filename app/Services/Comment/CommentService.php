<?php

namespace App\Services\Comment;

use App\Contracts\Dao\Comment\CommentDaoInterface;
use App\Contracts\Services\Comment\CommentServiceInterface;
use Illuminate\Support\Facades\Lang;

class CommentService implements CommentServiceInterface
{

    private $commentDao;

    /**
     * Summary of __construct
     * @param CommentDaoInterface $commentDaoInterface
     */
    public function __construct(CommentDaoInterface $commentDaoInterface)
    {
        $this->commentDao = $commentDaoInterface;
    }

    /**
     * Summary of create
     * @param mixed $validated
     * @return array
     */
    public function create($validated)
    {
        $status = $this->commentDao->create($validated);
        if ($status) {
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.commentcreate.success")
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.commentcreate.fail")
        ];
    }

    /**
     * Summary of get
     * @param mixed $course_id
     * @return array
     */
    public function get($course_id)
    {
        $comment = $this->commentDao->get($course_id);
        if ($comment->count() > 0) {
            foreach ($comment as $one) {
                $filter["id"] = $one->id;
                $filter["content"] = $one->content;
                $filter["user_id"] = $one->user_id;
                $filter["user_name"] = $one->user->name;
                $filter["course_id"] = $one->course_id;
                $filter["created_at"] = $one->created_at;
                $filter["updated_at"] = $one->updated_at;
                $final[] = $filter;
            }
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.commentget.success"),
                "data" => $final
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.commentget.fail")
        ];
    }

    /**
     * Summary of getByID
     * @param mixed $id
     * @return array
     */
    public function getByID($id)
    {
        $data = $this->commentDao->getByID($id);
        if ($data) {
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.commentgetid.found"),
                "data" => $data
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.commentgetid.notfound")
        ];
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param mixed $validated
     * @return array
     */
    public function update($id, $validated)
    {
        $data = $this->commentDao->update($id, $validated);
        if ($data) {
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.commentupdate.success")
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.commentupdate.fail")
        ];
    }

    /**
     * Summary of delete
     * @param mixed $id
     * @return array
     */
    public function delete($id)
    {
        $status = $this->commentDao->delete($id);
        if ($status) {
            return [
                "result" => intval(Lang::get("messages.result.success")),
                "message" => Lang::get("messages.commentdelete.success")
            ];
        }
        return [
            "result" => intval(Lang::get("messages.result.fail")),
            "message" => Lang::get("messages.commentdelete.fail")
        ];
    }
}
