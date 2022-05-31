<?php

return [

    "result" => [
        "success" => 1,
        "fail" => 0
    ],

    "validation" => [
        "success" => "Validation success",
        "fail" => "Validation error"
    ],

    "loginsuccess" => [
        "wrongemail" => "Your email is wrong.",
        "wrongpass" => "Your password is wrong.",
        "fail" => "Sorry, Login failed. Check your network and try again",
        "success" => "You have been login successfully"
    ],

    "coursecreate" => [
        "fail" => "Sorry, course couldn't add",
        "success" => "Course has been created successfully."
    ],

    "courseupdate" => [
        "notfound" => "ID not found",
        "success" => "Course has been updated successfully"
    ],
    
    "courseedit" => [
        "notfound" => "Course not found.",
        "success" => "Course has been found."
    ],

    "coursemaylike" => [
        "found" => "Courses has been found",
        "notfound" => "Courses not found according to this cateogory id."
    ],

    "topcourse" => [
        "notfound" => "No top course found or something's wrong.",
        "found" => "Top Courses found"
    ],

    "coursecurrentdata" => [
        "exist" => "Current Course Data exist.",
        "notexist" => "Current Course Data does not exist."
    ],

    "coursedatacancel" => [
        "success" => "Course data has been cancelled successfully",
        "notfound" => "Current data not found."
    ],

    "commentcreate" => [
        "success" => "Comment has been added successfully",
        "fail" => "Comment added failed."
    ],

    "commentget" => [
        "success" => "Comments exists with course id.",
        "fail" => "Comment not found or course id is invalid."
    ],

    "commentgetid" => [
        "found" => "Comment found",
        "notfound" => "Comment not found"
    ],

    "commentupdate" => [
        "success" => "Comment has been updated successfully",
        "fail" => "Comment update failed."
    ],

    "commentdelete" => [
        "success" => "Comment has been deleted successfully.",
        "fail" => "Comment delete failed."
    ],

    "logout" => [
        "success" => "You have been logout successfully.",
        "fail" => "Logout failed"
    ]

];
