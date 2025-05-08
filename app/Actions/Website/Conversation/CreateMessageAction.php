<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Events\Chat;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateMessageAction
{
    /**
     * Handle the incoming message creation request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'conversation_id' => 'required|integer|exists:conversations,id',
            'body' => 'required',
            'type' => 'nullable|string|in:text,attachment',
        ]);
        $studentId = Auth::guard('api_student')->id();
        $message = Message::create([
            'conversation_id' => $data['conversation_id'],
            'student_id' => $studentId,
            'type' => $data['type'] ?? 'text',
            'body' => $data['body'],

        ]);
        $otherStudentIds = Conversation::findOrFail($data['conversation_id'])->students()->where('students.id', '!=', $studentId)->pluck('students.id');
        $recipientsData = $otherStudentIds->map(function ($sid) use ($message, $data) {
            return [
                'student_id' => $sid,
                'conversation_id' => $data['conversation_id'],
                'message_id' => $message->id, ];
        })->toArray();
        Recipient::insert($recipientsData);

        event(new Chat($message));

        return ApiResponseHelper::sendResponse(new Result(MessageResource::make($message)));

    }
}
