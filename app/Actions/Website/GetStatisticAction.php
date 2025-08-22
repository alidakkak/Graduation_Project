<?php

namespace App\Actions\Website;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\HateMessageResource;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\Student;

class GetStatisticAction
{
    public function __invoke()
    {
        // فقط الرسائل اللي hate = 1
        $hateMessages = Message::where('hate', 1)
            ->with(['sender', 'conversation'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $countHateMessage        = Message::where('hate', 1)->count();
        $countStudent            = Student::count();
        $countVerifiedStudent    = Student::where('verified', 1)->count();
        $countNotVerifiedStudent = Student::where('verified', 0)->count();

        $data = [
            'countStudent'           => $countStudent,
            'countHateMessage'       => $countHateMessage,
            'countVerifiedStudent'   => $countVerifiedStudent,
            'countNotVerifiedStudent'=> $countNotVerifiedStudent,
            'hateMessages'           => HateMessageResource::collection($hateMessages),
        ];

        $pagination = [
            'total' => $hateMessages->total(),
            'current_page' => $hateMessages->currentPage(),
            'last_page' => $hateMessages->lastPage(),
            'per_page' => $hateMessages->perPage(),
        ];

        return ApiResponseHelper::sendResponseWithPagination(new Result($data, 'get messages successfully', $pagination));
    }
}
