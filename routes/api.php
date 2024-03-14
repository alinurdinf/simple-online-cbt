<?php

use App\Http\Controllers\API\ExamController;
use App\Http\Controllers\API\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('exam', [ExamController::class, 'all']);
    Route::get('question', [QuestionController::class, 'all']);
    Route::get('user', [UserController::class, 'fetch']);
});


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
