<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\Models\Conversation;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class ExitConversationAction
{
    public function __invoke(Conversation $conversation)
    {

        $studentId = Auth::guard('api_student')->id();
        Member::where('conversation_id', $conversation->id)->where('student_id', $studentId)->delete();

        return ApiResponseHelper::sendMessageResponse('exit group successfully');
    }
}
