<?php

namespace App\Http\Controllers;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\BotResource;
use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BotController extends Controller
{
    /**
     * إرسال رسالة إلى الـ API وتخزين الجواب.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $studentId = auth('api_student')->id();

        $response = Http::post('http://89.116.23.191:8070/chat', [
            'message' => $request->message,
        ]);

        if (! $response->ok()) {
            return response()->json(['message' => 'فشل الاتصال بالسيرفر الخارجي'], 500);
        }

        $answer = $response->json('answer');

        $bot = Bot::create([
            'student_id' => $studentId,
            'message' => $request->message,
            'answer' => $answer,
        ]);

        return response()->json([
            'message' => $bot->message,
            'answer' => $bot->answer,
        ]);
    }

    /**
     * عرض الرسائل السابقة للطالب مع التصفح.
     */
    public function index(Request $request)
    {
        $studentId = auth('api_student')->id();

        $messages = Bot::where('student_id', $studentId)
            ->latest()
            ->paginate(10); // يمكنك تعديل العدد حسب الحاجة
        $pagination = [
            'total' => $messages->total(),
            'current_page' => $messages->currentPage(),
            'last_page' => $messages->lastPage(),
            'per_page' => $messages->perPage(),
        ];

        return ApiResponseHelper::sendResponseWithPagination(new Result(BotResource::collection($messages->items()), 'get messages ', $pagination));
    }
}
