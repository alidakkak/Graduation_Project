<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lastMessage = $this->lastMessage;

        $lastMessageBody = null;

        if ($lastMessage) {
            if ($lastMessage->type === 'attachment') {
                // استخرج الامتداد من الرابط أو الاسم
                $extension = strtolower(pathinfo($lastMessage->body, PATHINFO_EXTENSION));

                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $lastMessageBody = 'image';
                } elseif (in_array($extension, ['mp4', 'mov', 'avi', 'mkv', 'webm'])) {
                    $lastMessageBody = 'video';
                } else {
                    $lastMessageBody = 'file';
                }
            } else {
                $lastMessageBody = $lastMessage->body;
            }
        }

        return [
            'id' => $this->id,
            'label' => $this->label,
            'new_messages' => $this->new_messages,
            'last_message' => [
                'Last_message_id' => $lastMessage?->id,
                'Last_message_Type' => $lastMessage?->type,
                'Last_message_Body' => $lastMessageBody,
                'Last_message_Sender' => $lastMessage?->sender?->first_name,
            ],
        ];
    }
}
