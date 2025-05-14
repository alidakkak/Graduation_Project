<?php

use App\Actions\Website\Conversation\CreateGroupAction;
use App\Actions\Website\Conversation\CreateMessageAction;
use App\Actions\Website\Conversation\ExitConversationAction;
use App\Actions\Website\Conversation\GetConversationAction;
use App\Actions\Website\Conversation\GetMessagesAction;
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
// conversation
Route::group(['middleware' => ['auth:api_student']], function () {
    Route::get('conversation', GetConversationAction::class);
    Route::post('message', CreateMessageAction::class);
    Route::post('group', CreateGroupAction::class);
    Route::delete('exitConversation/{conversation}', ExitConversationAction::class);
});

Route::post('studentRegistration', [StudentController::class, 'studentRegistration']);
Route::put('studentRegistrationComplete/{student:id}', [StudentController::class, 'studentRegistrationComplete']);
Route::post('studentLogin', [StudentController::class, 'login']);
Route::get('getSubject', [StudentController::class, 'getSubject']);
