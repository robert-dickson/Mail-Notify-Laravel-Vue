<?php

use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Get all user data

Route::get('/user', [UserController::class, 'getUser']);

// Register a new user
Route::get('/registration_form', [UserController::class, 'registrationForm']);
// Route::post('/register', [UserController::class, 'register']);

// Log in a user
Route::post('/login', [UserController::class, 'login']);

Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{task_id}', [TaskController::class, 'update']);
Route::delete('/tasks/{task_id}', [TaskController::class, 'destroy']);
Route::get('/tasks/task_list', [TaskController::class, 'index']);

Route::post('/tasks/{task_id}/subtasks', [SubtaskController::class, 'store']);
Route::put('/subtasks/{subtask_id}', [SubtaskController::class, 'update']);
Route::delete('/subtasks/{subtask_id}', [SubtaskController::class, 'destroy']);
