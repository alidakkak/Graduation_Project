<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Models\Conversation;
use Illuminate\Http\Request;

class GetMemberAction
{
    public function __invoke(Request $request, Conversation $conversation)
    {

        $members = $conversation->members()->get()->map(function ($member) {
            return [
                'id' => $member->id,
                'name' => $member->first_name.' '. $member->father_name.' '.$member->last_name,
            ];
        });

        return ApiResponseHelper::sendResponse(new Result($members));
    }
}
