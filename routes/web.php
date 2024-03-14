<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AssestmentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('user', UserController::class)->only([
        'index'
    ]);

    Route::resource('exam', ExamController::class)->shallow()->only([
        'index', 'create', 'store', 'show'
    ]);

    Route::resource('question', QuestionController::class)->only([
        'store'
    ]);

    Route::resource('result', ResultController::class)->only([
        'index'
    ]);

    Route::resource('assessment', AssessmentController::class)->shallow()->only([
        'index'
    ]);

    Route::post('assessment/check', [AssessmentController::class, 'assessment_check'])->name('assessment.assessment_check');
    Route::get('assessment/home', [AssessmentController::class, 'assessment_home'])->name('assessment.assessment_home');
    Route::post('assessment/store', [AssessmentController::class, 'assessment_store'])->name('assessment.assessment_store');
    Route::get('assessment/test', [AssessmentController::class, 'assessment_index'])->name('assessment.assessment_index');
    Route::post('assessment/update', [AssessmentController::class, 'assessment_update'])->name('assessment.assessment_update');
    Route::get('assessment/result', [AssessmentController::class, 'assessment_result'])->name('assessment.assessment_result');

    Route::get('assessment/finish', [AssessmentController::class, 'assessment_finish'])->name('assessment.assessment_finish');

    Route::delete('question/delete/{encrypted_id}', [QuestionController::class, 'destroy'])->name('question.destroy');

    Route::delete('exam/delete/{encrypted_id}', [ExamController::class, 'destroy'])->name('exam.destroy');
});
