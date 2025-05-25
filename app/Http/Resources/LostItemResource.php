<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LostItemResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image ? url($this->image) : null,
            'date_of_loss' => $this->date_of_loss,
            'status' => $this->status,
            'created_at' => $this->created_at->diffForHumans(),
            'comments' => CommentResource::collection($this->whenLoaded('comments'))
        ];
    }
}
