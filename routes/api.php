<?php

use App\Http\Controllers\MakeTaskDoneController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/tasks',TaskController::class)->except('destroy');
Route::put('/task/{task}/make-task-done',[MakeTaskDoneController::class,'__invoke']);

