<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'type' => $this->type,
            'hate' => boolval($this->hate),
            'body' => $this->type == 'text' ? $this->body : asset($this->body),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'sender_id' => $this->sender?->id,
            'sender_name' => $this->sender?->first_name,
            'profileImage' => asset($this->sender?->profileImage),
            'replay' => MessageResource::make($this->replay),

        ];
    }
}
