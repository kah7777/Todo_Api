<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MakeTaskDoneController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\SanctumServiceProvider;

Route::apiResource('/tasks',TaskController::class)->except('destroy')->middleware('auth:sanctum');
Route::put('/task/{task}/make-task-done',[MakeTaskDoneController::class,'__invoke'])->middleware('api');
Route::post('/register',[AuthController::class,'registerIfNotExisted']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout'])->middleware('api');
