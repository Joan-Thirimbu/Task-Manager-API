<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/tasks/trashed', [TaskController::class, 'trashed']);
    Route::delete('/tasks/{task}/force', [TaskController::class, 'forceDelete']);
    Route::patch('/tasks/{id}/restore', [TaskController::class, 'restore']);

    Route::apiResource('tasks', TaskController::class);
});