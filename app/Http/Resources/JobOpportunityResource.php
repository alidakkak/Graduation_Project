<?php

namespace App\Http\Resources;

use App\Statuses\JobType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobOpportunityResource extends JsonResource
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
            'company' => $this->company,
            'location' => $this->location,
            'job_type' => $this->job_type,
            'job_type_name' => JobType::label($this->job_type),
            'is_expired' => $this->is_expired,
            'created_at' => $this->created_at->diffForHumans(),
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image' => asset($image->image),
                ];
            }),
        ];
    }
}
