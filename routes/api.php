<?php

use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Course\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user/register', [UserAuthController::class, 'registerUser']);
Route::post('/user/login', [UserAuthController::class, 'loginUser']);
Route::post('/register/confirm', [UserController::class, 'registerConfirm']);

Route::middleware('auth:api')->group(function () {
    Route::post('/user/logout', [UserAuthController::class, 'logoutUser']);
    Route::get('/user/list',[UserController::class, ' getAllUser']);
    Route::get('/admin/show/{id}',[UserController::class, 'show']);
    Route::get('/user/show/{id}',[UserController::class, 'show']);
    Route::get('/user/disable/{id}', [UserController::class, 'disableUser']);
    Route::post('/course/create', [CourseController::class, 'createCourse']);
    Route::get('/course/get_all', [CourseController::class, 'getAllCourse']);
    Route::apiResource('categories', \Category\CategoryController::class);
    Route::post('/course/create', [CourseController::class, 'createCourse']);
    Route::post('/course/create/confirm', [CourseController::class, 'createConfirm']);
    Route::put('/course/update/{id}', [CourseController::class, 'updateCourse']);
    Route::put('/course/update/confirm/{id}', [CourseController::class, 'updateConfirm']);
    Route::delete('/course/delete/{id}', [CourseController::class, 'deleteCourse']);
    Route::get('/course/search/{keyword}', [CourseController::class, 'searchCourse']);
    Route::get('/course/detail/{id}', [CourseController::class, 'detailCourse']);
    Route::post('/comment/create', [CommentController::class, 'createComment']);
    Route::get('/comment/course/{id}', [CommentController::class, 'getcommentCourse']);
    Route::delete('/comment/delete/{id}', [CommentController::class, 'deleteCommentID']);
    Route::get('/comment/get/{id}', [CommentController::class, 'getCommentID']);
    Route::put('/comment/update/{id}', [CommentController::class, 'updateComment']);
    Route::get('/course/youmaylike/{id}', [CourseController::class, 'getCoureMayLike']);
});
