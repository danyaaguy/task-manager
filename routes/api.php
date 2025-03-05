<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

// Методы для авторизованных пользователей
Route::middleware(['auth:sanctum'])->group(function ()
{
    Route::post('tasks', [TaskController::class, 'store'])->middleware(['trottle:tasks']);
    
    Route::post('tasks/{task}/assign', [TaskController::class, 'assign']);  
    Route::delete('tasks/{task}/unassign/{user}', [TaskController::class, 'unassign']);  
    
    Route::resource('users', UserController::class);
    Route::resource('tasks', TaskController::class);
});
