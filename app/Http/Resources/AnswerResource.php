<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'body' => $this->body,
            'check' => boolval($this->check),
            'student_id' => $this->student_id,
            'full_name' => $this->first_name.'  '.$this->last_name,
            'created_at' => $this->created_at,
        ];

    }
}
