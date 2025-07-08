<?php

use App\Actions\Website\Conversation\CreateGroupAction;
use App\Actions\Website\Conversation\CreateMessageAction;
use App\Actions\Website\Conversation\ExitConversationAction;
use App\Actions\Website\Conversation\GetConversationAction;
use App\Actions\Website\Conversation\GetFilesAction;
use App\Actions\Website\Conversation\GetMemberAction;
use App\Actions\Website\Conversation\GetMessagesAction;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes

| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('studentRegistration', [StudentController::class, 'studentRegistration']);
Route::put('studentRegistrationComplete/{student:id}', [StudentController::class, 'studentRegistrationComplete']);
Route::post('studentLogin', [StudentController::class, 'login']);
Route::get('getSubject', [StudentController::class, 'getSubject']);

Route::group(['middleware' => ['auth:api_student']], function () {
    // // conversation
    Route::get('conversation', GetConversationAction::class);
    Route::get('/conversations/{conversation}', GetMessagesAction::class);
    Route::get('/members/{conversation}', GetMemberAction::class);
    Route::get('/files/{conversation}', GetFilesAction::class);
    Route::post('message', CreateMessageAction::class);
    Route::post('group', CreateGroupAction::class);
    Route::delete('exitConversation/{conversation}', ExitConversationAction::class);

    // // Lost Item
    Route::get('lostItems', [LostItemController::class, 'index']);
    Route::get('lostItem/{id}', [LostItemController::class, 'show']);
    // // Comment (Lost Item)
    Route::post('addNewComment', [LostItemController::class, 'addNewComment']);
    Route::post('updateComment/{id}', [LostItemController::class, 'updateComment']);
    Route::get('getCommentWithReplies/{lostItemID}', [LostItemController::class, 'getCommentWithReplies']);

    // ////  Announcements
    Route::get('getAnnouncements', [AnnouncementController::class, 'getAnnouncements']);
    Route::get('showAnnouncement/{id}', [AnnouncementController::class, 'show']);

    // //// Job Opportunity
    Route::get('getJobOpportunities', [JobOpportunityController::class, 'index']);
    Route::get('showJobOpportunity/{id}', [JobOpportunityController::class, 'show']);

    // //// questions
    Route::resource('questions',QuestionController::class);
    Route::get('answer/{question:id}',[AnswerController::class,'index']);
    Route::resource('answer',AnswerController::class)->except(['show','index']);


});
