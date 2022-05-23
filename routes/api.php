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

Route::post('/register', [UserAuthController::class, 'registerUser']);
Route::post('/login', [UserAuthController::class, 'loginUser']);

Route::middleware('auth:api')->group(function () {
    Route::post('/create-course', [CourseController::class, 'createCourse']);
    Route::apiResource('categories', \Category\CategoryController::class);
    Route::get('/edit-course/{id}', [CourseController::class, 'editCourse']);
    Route::put('/update-course/{id}', [CourseController::class, 'updateCourse']);
});
