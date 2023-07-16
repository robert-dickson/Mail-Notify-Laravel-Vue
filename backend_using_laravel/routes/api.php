<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [UserController::class, 'Register']);
//Get all user data

Route::get('/user', [UserController::class, 'GetUser']);

// Log in a user
Route::post('/login', [UserController::class, 'Login']);
Route::post('/send_mail', [UserController::class, 'SendMail']);
Route::post('/otp_verify', [UserController::class, 'OtpVerify']);
Route::post('/set_password', [UserController::class, 'SetPassword']);
Route::post('/profile_update', [UserController::class, 'ProfileUpdate']);

Route::post('/task_reminder', [TaskController::class, 'TaskReminder']);

Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{task_id}', [TaskController::class, 'update']);
Route::delete('/tasks/{task_id}', [TaskController::class, 'destroy']);
Route::get('/tasks/task_list', [TaskController::class, 'index']);

Route::post('/tasks/{task_id}/subtasks', [SubtaskController::class, 'store']);
Route::put('/subtasks/{subtask_id}', [SubtaskController::class, 'update']);
Route::delete('/subtasks/{subtask_id}', [SubtaskController::class, 'destroy']);
Route::get('/tasks/subtask_list', [SubtaskController::class, 'index']);
