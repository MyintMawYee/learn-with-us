<?php

use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Course\CourseController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->group(function () {
    Route::post('/course/create', [CourseController::class, 'createCourse']);
    Route::get('/course/get_all', [CourseController::class, 'getAllCourse']);
    Route::delete('/course/delete/{id}', [CourseController::class, 'deleteCourse']);
    Route::apiResource('categories', \Category\CategoryController::class);
    Route::get('/course/edit/{id}', [CourseController::class, 'editCourse']);
    Route::put('/course/update/{id}', [CourseController::class, 'updateCourse']);
    Route::get('/course/search/{keyword}', [CourseController::class, 'searchCourse']);
});
