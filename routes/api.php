<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\CheckOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::get('/classrooms', [ClassroomController::class, 'index']);
    Route::post('/classrooms/{id}', [ClassroomController::class, 'show'])->middleware(CheckOwnership::class);
    Route::post('/classrooms', [ClassroomController::class, 'store']);
    Route::patch('/classrooms/{id}', [ClassroomController::class, 'update'])->middleware(CheckOwnership::class);
    Route::delete('/classrooms/{id}', [ClassroomController::class, 'destroy'])->middleware(CheckOwnership::class);
});

Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::post('classroom/{id_classroom}/students', [StudentController::class, 'store']);
});