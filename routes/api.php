<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/tasks',TaskController::class)->except('destroy');
Route::get('/task/{task}/done',[TaskController::class,'indexDone']);

