<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HateMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'body' => $this->body,
            'created_at' => $this->created_at->toDateTimeString(),
            'sender' => $this->sender ? $this->sender->first_name.' '.$this->sender->last_name : null,
            'group' => $this->conversation ? $this->conversation->label : null,
        ];
    }
}
