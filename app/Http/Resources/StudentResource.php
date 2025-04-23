<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'full_name' => $this->first_name.' '.$this->father_name.' '.$this->last_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'university_number' => $this->university_number,
            'image' => $this->image,
            'verified' => boolval($this->verified),
            'is_registration_complete' => $this->is_registration_complete,
        ];
    }
}
