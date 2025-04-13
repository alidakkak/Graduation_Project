<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\PublicAnnouncementController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

// Route::group(['middleware' => 'check_user:1'], function () {

// });

// / Student
Route::get('getStudentNotRegistrationComplete', [StudentController::class, 'getStudentNotRegistrationComplete']);
Route::patch('checkStudentData/{id}', [StudentController::class, 'checkStudentData']);

// // Public Announcements
Route::post('announcement', [PublicAnnouncementController::class, 'store']);
Route::post('announcement/{id}', [PublicAnnouncementController::class, 'update']);
Route::get('announcements', [PublicAnnouncementController::class, 'index']);
Route::get('announcement/{id}', [PublicAnnouncementController::class, 'show']);
Route::delete('announcement/{id}', [PublicAnnouncementController::class, 'delete']);

// // Job Opportunity
Route::post('jobOpportunity', [JobOpportunityController::class, 'store']);
Route::post('jobOpportunity/{id}', [JobOpportunityController::class, 'update']);
Route::get('jobOpportunities', [JobOpportunityController::class, 'index']);
Route::get('jobOpportunity/{id}', [JobOpportunityController::class, 'show']);
Route::delete('jobOpportunity/{id}', [JobOpportunityController::class, 'delete']);
