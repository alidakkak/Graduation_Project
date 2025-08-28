<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetUsersAction
{
    public function __invoke(Request $request)
    {
        $search = $request->input('search');

        if (! $search) {
            return ApiResponseHelper::sendMessageResponse(
                'البحث مطلوب'
            );
        }

        if (mb_strlen($search) < 3) {
            return ApiResponseHelper::sendMessageResponse(
                'الرجاء إدخال 3 أحرف على الأقل للبحث'
            );
        }

        $query = Student::query();

        $query->where(
            DB::raw("CONCAT(first_name, ' ', father_name, ' ', last_name)"),
            'LIKE',
            $search.'%'
        )->where('verified', 1)->where('id', '=!', Auth::guard('api_student')->id());

        $users = $query
            ->select(
                'id',
                DB::raw("CONCAT(first_name, ' ', father_name, ' ', last_name) as full_name")
            )
            ->orderBy('first_name')
            ->orderBy('father_name')
            ->orderBy('last_name')
            ->paginate(10);

        return ApiResponseHelper::sendResponse(
            new Result(
                $users->items(),
                'تم جلب المستخدمين بنجاح'
            )
        );
    }
}
