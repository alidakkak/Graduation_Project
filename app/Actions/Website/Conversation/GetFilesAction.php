<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;

class GetFilesAction
{
    public function __invoke(Conversation $conversation)
    {

        $messages = $conversation->messages()
            ->with('sender')
            ->where('type', 'attachment')
            ->orderBy('id', 'desc')
            ->get();

        return ApiResponseHelper::sendResponse(new Result(MessageResource::collection($messages), 'get messages successfully'));
    }
}
