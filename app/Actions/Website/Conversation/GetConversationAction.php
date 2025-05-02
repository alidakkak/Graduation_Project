<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\ConversationResource;
use App\Models\Student;

class GetConversationAction
{
    public function __invoke()
    {
        $user = Student::first();

        $conversations = $user->conversations()
            ->with([
                'lastMessage' => function ($builder) {
                    $builder->with(['sender' => function ($builder) {
                        $builder->select('id', 'first_name');
                    }]);
                },
            ])->withCount([
                'recipients as new_messages' => function ($builder) use ($user) {
                    $builder->where('recipients.student_id', $user->id)->whereNull('read_at');
                }])->get();

        $conversations = ConversationResource::collection($conversations);

        return ApiResponseHelper::sendResponse(new Result($conversations));

    }
}
