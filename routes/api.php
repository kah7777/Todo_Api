<?php

use App\Http\Controllers\AddRandomTaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MakeTaskDoneController;
use App\Http\Controllers\RetrieveEndedDeadlineTaskForNotificationsController;
use App\Http\Controllers\RetrieveProfilePictureController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TopUsersWithMostDoneTasksController;
use App\Http\Controllers\UploadProfilePictureController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/tasks', TaskController::class)->except('destroy')->middleware('auth:sanctum');
Route::put('/task/{task}/make-task-done', MakeTaskDoneController::class)->middleware('auth:sanctum');
Route::apiResource('/tasks/notifications', TaskController::class)->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'registerIfNotExisted']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/notifications', RetrieveEndedDeadlineTaskForNotificationsController::class)->middleware('auth:sanctum');
Route::get('/job-test', AddRandomTaskController::class)->middleware('auth:sanctum');
Route::get('/leaderboard', TopUsersWithMostDoneTasksController::class)->middleware('auth:sanctum');
Route::post('/upload-profile-picture', UploadProfilePictureController::class)->middleware('auth:sanctum');
Route::get('/retrieve-profile-picture', RetrieveProfilePictureController::class)->middleware('auth:sanctum');
