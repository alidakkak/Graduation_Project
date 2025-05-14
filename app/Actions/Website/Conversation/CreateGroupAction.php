<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Events\Chat;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Member;
use App\Models\Message;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateGroupAction
{
    /**
     * Handle the incoming message creation request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $data =$request->validate([
            'label' => 'required|string',
        ]);
        $studentId = Auth::guard('api_student')->id();
        $conversation = Conversation::create([
            'student_id' => $studentId,
            'type' => 'group',
            'label' => $data['label'],

        ]);
     $member=   Member::create([
            'student_id' => $studentId,
            'conversation_id'=>$conversation->id
        ]);

        return ApiResponseHelper::sendMessageResponse('create successfully');

    }
}
