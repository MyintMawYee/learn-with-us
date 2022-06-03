<?php

use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Course\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Middleware\IsAdmin;

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
//Route::get('/register/confirm', [UserController::class, 'getRegisterConfirm']);
//Route::post('/register/confirm', [UserController::class, 'registerConfirm']);
Route::get('/course/top', [CourseController::class, 'getTopCourse']);
Route::get('/categories/show/{category}', [CategoryController::class, 'show']);
Route::get('/course/detail/{id}', [CourseController::class, 'detailCourse']);

Route::middleware('auth:api')->group(function() {
    Route::get('/course/detail/{id}', [CourseController::class, 'detailCourse']);
    Route::post('/user/change/password', [UserController::class, 'changePassword']);
    Route::post('/user/logout', [UserAuthController::class, 'logoutUser']);
    Route::get('/user/show/{id}', [UserController::class, 'show']);
    Route::get('/course/get_all', [CourseController::class, 'getAllCourse']);
    Route::get('/course/search/{keyword}', [CourseController::class, 'searchCourse']);
    Route::post('/course/buy', [CourseController::class, 'buyCourse']);
    Route::get('/course/show/{id}', [CourseController::class, 'getMyCourse']);
    Route::post('/comment/create', [CommentController::class, 'createComment']);
    Route::get('/comment/course/{id}', [CommentController::class, 'getcommentCourse']);
    Route::delete('/comment/delete/{id}', [CommentController::class, 'deleteCommentID']);
    Route::get('/comment/get/{id}', [CommentController::class, 'getCommentID']);
    Route::put('/comment/update/{id}', [CommentController::class, 'updateComment']);
    Route::get('/course/youmaylike/{id}', [CourseController::class, 'getCoureMayLike']);
});

Route::middleware([IsAdmin::class])->group(function() {
    Route::get('/admin/show/{id}', [UserController::class, 'show']);
    Route::post('/admin/change/password', [UserController::class, 'changePassword']);
    //Route::post('/course/create/confirm', [CourseController::class, 'createConfirm']);
    Route::get('/user/list', [UserController::class, 'getAllUser']);
    Route::get('/user/count', [UserController::class, 'countUser']);
    Route::get('/user/disable/{id}', [UserController::class, 'disableUser']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/show_name/{category}', [CategoryController::class, 'showCategoryName']);
    Route::get('/categories/count', [CategoryController::class, 'countCategory']);
    Route::get('/categories/count_purchase', [CategoryController::class, 'countPurchaseCategory']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::post('/course/create', [CourseController::class, 'createCourse']);
    Route::put('/course/update/{id}', [CourseController::class, 'updateCourse']);
    //Route::put('/course/update/confirm/{id}', [CourseController::class, 'updateConfirm']);
    Route::delete('/course/delete/{id}', [CourseController::class, 'deleteCourse']);
    Route::get('/course/count', [CourseController::class, 'countCourse']);
    Route::get('/user/export', [UserController::class, 'export']);
    Route::post('/user/import', [UserController::class, 'import']);
    //Route::get('/course/get/data', [CourseController::class, 'getCurrentData']);
    //Route::get('/course/cancel', [CourseController::class , 'cancelCourse']);
});



