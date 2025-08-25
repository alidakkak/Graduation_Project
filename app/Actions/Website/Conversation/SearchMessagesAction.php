<?php

namespace App\Actions\Website\Conversation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Models\Conversation;

class SearchMessagesAction
{
    public function __invoke(Request $request, Conversation $conversation)
    {
        // نتحقق من البيانات القادمة
        $data = $request->validate([
            'query' => 'required|string',
        ]);

        try {
            // نرسل الطلب للـ API الخارجي
            $response = Http::post('http://89.116.23.191:8100/api/search', [
                'query'        => $data['query'],
                'use_hybrid'   =>  true,
                'use_reranking'=> true,
                'top_k'        =>  3,
                'group_id'     =>$conversation->id
            ]);

            if ($response->failed()) {
                return ApiResponseHelper::sendMessageResponse('Search API failed', 500);
            }

            $result = $response->json();

            $messages = collect($result['results'] ?? [])->map(function ($item) {
                return [
                    'message_id' => $item['message']['message_id'] ?? null,
                    'text'       => $item['message']['text'] ?? null,
                ];
            });

            return ApiResponseHelper::sendResponse(new Result([
                'query'  => $result['query'] ?? null,
                'total'  => $result['metadata']['returned_results'] ?? 0,
                'messages' => $messages,
            ]));
        } catch (\Exception $e) {
            return ApiResponseHelper::sendMessageResponse('Exception: '.$e->getMessage(), 500);
        }
    }
}
