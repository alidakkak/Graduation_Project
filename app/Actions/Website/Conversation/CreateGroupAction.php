<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\Models\Conversation;
use App\Models\Member;
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
        $data = $request->validate([
            'label'     => 'required|string',
            'members'   => 'required|array|min:1',  // لازم يكون فيه عضو واحد على الأقل
            'members.*' => 'integer|exists:students,id',
        ]);

        $studentId = Auth::guard('api_student')->id();

        // إنشاء المحادثة (جروب)
        $conversation = Conversation::create([
            'student_id' => $studentId,
            'type'       => 'group',
            'label'      => $data['label'],
        ]);

        // إضافة المنشئ نفسه كعضو
        Member::create([
            'student_id'      => $studentId,
            'conversation_id' => $conversation->id,
        ]);

        // إضافة باقي الأعضاء
        foreach ($data['members'] as $memberId) {
            if ($memberId != $studentId) {
                Member::create([
                    'student_id'      => $memberId,
                    'conversation_id' => $conversation->id,
                ]);
            }
        }

        return ApiResponseHelper::sendMessageResponse('Group created successfully');
    }
}
