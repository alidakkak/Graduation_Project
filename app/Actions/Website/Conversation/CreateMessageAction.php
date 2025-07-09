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
use Illuminate\Support\Facades\Http;

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
            'replay_message_id' => 'nullable|integer|exists:messages,id',
            'body' => 'required',
            'type' => 'nullable|string|in:text,attachment',
        ]);
        $studentId = Auth::guard('api_student')->id();
        // فحص الكراهية
        $isHate = false;
        if (($data['type'] ?? 'text') === 'text') {
            try {
                $response = Http::post('http://89.116.23.191:8090/predict', [
                    'text' => $data['body'],
                ]);

                if ($response->successful()) {
                    $result = $response->json();
                    $isHate = $result['is_hate'] ?? false;
                }
            } catch (\Exception $e) {
                \Log::error('Hate speech detection API failed: '.$e->getMessage());
            }
        }

        $message = Message::create([
            'conversation_id' => $data['conversation_id'],
            'student_id' => $studentId,
            'type' => $data['type'] ?? 'text',
            'body' => $data['body'],
            'message_id' => $data['replay_message_id'] ?? null,
            'hate' => $isHate,
        ]);

        Conversation::where('id', $data['conversation_id'])->update(['last_message_id' => $message->id]);
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
