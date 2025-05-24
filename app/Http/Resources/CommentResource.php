<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment' => $this->comment,
            'image' => $this->image ? url($this->image) : null,
            'created_at' => $this->created_at->diffForHumans(),
            'studentID' => $this->student->id,
            'full_name' => $this->student->first_name.' '.$this->student->father_name.' '.$this->student->last_name,
            'profileImage' => url($this->student->profileImage),
            'replies'    => CommentResource::collection($this->whenLoaded('children')),
        ];
    }
}
