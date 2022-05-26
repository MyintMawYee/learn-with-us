<?php

namespace App\Services\Comment;

use App\Contracts\Dao\Comment\CommentDaoInterface;
use App\Contracts\Services\Comment\CommentServiceInterface;

class CommentService implements CommentServiceInterface {

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
        "result" => 1,
        "message" => "Comment has been added successfully."
      ];
    }
    return [
      "result" => 0,
      "message" => "Comment added failed."
    ];
  }

  /**
   * Summary of get
   * @param mixed $course_id
   * @return mixed
   */
  public function get($course_id)
  {
    return $this->commentDao->get($course_id);
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
        "result" => 1,
        "message" => "Comment found",
        "data" => $data
      ];
    }
    return [
      "result" => 0,
      "message" => "Comment not found."
    ];
  }

  /**
   * Summary of update
   * @param mixed $id
   * @param mixed $validated
   * @return array
   */
  public function update($id,$validated)
  {
    $data = $this->commentDao->update($id, $validated);
    if ($data) {
      return [
        "result" => 1,
        "message" => "Comment has been updated successfully."
      ];
    }
    return [
      "result" => 0,
      "message" => "Comment update failed"
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
        "result" => 1,
        "message" => "Comment has been deleted successfully."
      ];
    }
    return [
      "result" => 0,
      "message" => "Comment delete failed."
    ];
  }

}