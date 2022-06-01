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

    "registersuccess" => [
        "wrongemail" => "Your email is wrong.",
        "wrongpass" => "Your password is wrong.",
        "fail" => "Sorry, Register failed. Check your network and try again",
        "success" => "Registerd successfully"
    ],

    "passwordchange" => [
        "fail" => "Password can not be changed",
        "success" => "Password can be changed successfully"
    ],

    "usershow" => [
       "success" => "User lists"
    ],

    "coursecreate" => [
        "success" => "Sorry, course couldn't add",
        "fail" => "Course has been created successfully."
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

    "mycourse" => [
        "notfound" => "No  course found or something's wrong.",
        "found" => "My Courses"
    ],

    "topcourse" => [
        "notfound" => "No top course found or something's wrong.",
        "found" => "Top Courses found"
    ],

    "searchdata" => [
        "notfound" => "No search data found or something's wrong.",
        "found" => "Search data are found"
    ],

    "coursecurrentdata" => [
        "exist" => "Current Course Data exist.",
        "notexist" => "Current Course Data does not exist."
    ],

    "coursedatacancel" => [
        "success" => "Course data has been cancelled successfully",
        "notfound" => "Current data not found."
    ],

    "coursebuy" => [
        "fail" => "Your purchase is fail",
        "success" => "Your purchase is success"
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
