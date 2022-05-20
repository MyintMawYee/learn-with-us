<?php

use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\User\UserAuthController;
use Illuminate\Http\Request;
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

Route::post('/register', [UserAuthController::class, 'userRegister']);
Route::post('/login', [UserAuthController::class, 'userLogin']);
Route::post('/course/create', [CourseController::class, 'createCourse']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
