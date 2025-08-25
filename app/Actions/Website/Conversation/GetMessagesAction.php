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
            'message_id' => 'nullable|integer|min:1',
        ]);

        $studentId = Auth::guard('api_student')->id();

        $perPage = $data['per_page'] ?? 100;

        // حالة عدم تمرير message_id => نفس السلوك القديم (paginate تنازلي)
        if (empty($data['message_id'])) {
            $messages = $conversation->messages()
                ->with(['sender', 'replay'])
                ->where('hate',0)
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

            return ApiResponseHelper::sendResponseWithPagination(
                new Result(MessageResource::collection($messages->items()), 'get messages successfully', $pagination)
            );
        }

        // حالة وجود message_id
        $messageId = (int) $data['message_id'];

        // نأخذ أقل من message_id بعدد perPage (أقرب أولاً)، ثم نرتبها تصاعدياً
        $older = $conversation->messages()
            ->with(['sender', 'replay'])
            ->where('id', '<', $messageId)
            ->where('hate',0)
            ->orderBy('id', 'desc')
            ->limit($perPage)
            ->get()
            ->sortBy('id')   // ليصبح الترتيب الطبيعي: أصغر -> أكبر (مثال: 4,5)
            ->values();

        // نأخذ الرسالة نفسها وكل الرسائل الأحدث (id >= message_id) بترتيب تصاعدي
        $newer = $conversation->messages()
            ->with(['sender', 'replay'])
            ->where('id', '>=', $messageId)
            ->where('hate',0)
            ->orderBy('id', 'desc')
            ->get()
            ->values();

        // ندمج older ثم newer
        $combined = $newer->concat($older);

        // نعلم القراءة كما السابق
        Recipient::where('student_id', $studentId)
            ->where('conversation_id', $conversation->id)
            ->update(['read_at' => now()]);

        // نعيد نفس حقول الـ pagination (نحسبها بناءً على إجمالي الرسائل في المحادثة)
        $totalMessages = $older->count();

        $pagination = [
            'total' => $totalMessages,
            'current_page' => 1,
            'last_page' => (int) ceil($totalMessages / $perPage),
            'per_page' => $perPage,
        ];

        return ApiResponseHelper::sendResponseWithPagination(
            new Result(MessageResource::collection($combined), 'get messages successfully', $pagination)
        );
    }
}
