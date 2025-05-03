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

        return [
            'id' => $this->id,
            'label' => $this->label,
            'new_messages' => $this->new_messages,
            'last_message' => [
                'Last_message_id' => $this->lastMessage?->id,
                'Last_message_Type' => $this->lastMessage?->type,
                'Last_message_Body' => $this->lastMessage?->type === 'attachment' ? asset($this->lastMessage?->body) : $this->lastMessage?->body,
                'Last_message_Sender' => $this->lastMessage?->sender?->first_name,
            ],

        ];
    }
}
