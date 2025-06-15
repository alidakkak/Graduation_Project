<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetMessagesAction
{
    public function __invoke(Request $request, Conversation $conversation)
    {
        $data = $request->validate([
            'per_page' => 'nullable|integer|min:1',
        ]);

        $studentId = Auth::guard('api_student')->id();

        $perPage = $data['per_page'] ?? 20;

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        Recipient::where('student_id', $studentId)
            ->where('conversation_id', $conversation->id)
            ->update(['read_at' => now()]);
        $pagination = [
            'total' => $messages->total(),
            'current_page' => $messages->currentPage(),
            'last_page' => $messages->lastPage(),
            'per_page' => $messages->perPage(),
        ];

        return ApiResponseHelper::sendResponseWithPagination(new Result(MessageResource::collection($messages->items()),'get messages successfully',$pagination));
    }
}
