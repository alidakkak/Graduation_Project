<?php

namespace App\Actions\Website\Conversation;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchMessagesAction
{
    public function __invoke(Request $request, Conversation $conversation)
    {
        // نتحقق من البيانات القادمة
        $data = $request->validate([
            'query' => 'required|string',
        ]);
        $query = preg_replace('/\p{Cf}/u', '', $data['query']);

        try {
            // نرسل الطلب للـ API الخارجي
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('http://89.116.23.191:8100/api/search', [
                'query' => $query,
                'use_hybrid' => true,
                'use_reranking' => true,
                'top_k' => 10,
                'group_id' => (string) $conversation->id,
            ]);
            if ($response->failed()) {
                return ApiResponseHelper::sendMessageResponse('Search API failed', 500, false);
            }

            $result = $response->json();
            $messages = collect($result['results'] ?? [])->map(function ($item) {
                return [
                    'message_id' => $item['message']['message_id'] ?? null,
                    'text' => $item['message']['text'] ?? null,
                    'sender_name' => $item['message']['sender'] ?? null,

                ];
            });

            return ApiResponseHelper::sendResponse(new Result([
                'query' => $result['query'] ?? null,
                'total' => $result['metadata']['returned_results'] ?? 0,
                'messages' => $messages,
            ]));
        } catch (\Exception $e) {
            return ApiResponseHelper::sendMessageResponse('Exception: '.$e->getMessage(), 500);
        }
    }
}
