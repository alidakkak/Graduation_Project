<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SemesterResource extends JsonResource
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
            'semesterName' => $this->getSemesterName()
        ];
    }
    private function getSemesterName(): string
    {
        return match ($this->semester) {
            '1' => 'الفصل الأول',
            '2' => 'الفصل الثاني',
            default => 'غير معروف',
        };
    }
}
