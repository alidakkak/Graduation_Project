<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

// Route::group(['middleware' => 'check_user:1'], function () {

// });

Route::get('getStudentNotRegistrationComplete', [StudentController::class, 'getStudentNotRegistrationComplete']);
Route::put('checkStudentData/{id}', [StudentController::class, 'checkStudentData']);
