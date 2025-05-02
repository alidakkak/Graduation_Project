<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicAnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'created_at' => $this->created_at->diffForHumans(),
                'academicYearName' => $this->getAcademicYearName(),
                'specializationName' => $this->getSpecializationName(),
                'images' => $this->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image' => asset($image->image),
                    ];
                }),
            ];
    }

    private function getAcademicYearName(): string
    {
        return match ($this->academic_year) {
            '1' => 'السنة الأولى',
            '2' => 'السنة الثانية',
            '3' => 'السنة الثالثة',
            '4' => 'السنة الرابعة',
            '5' => 'السنة الخامسة',
            '6' => 'عام',
            default => 'غير معروفة',
        };
    }

    private function getSpecializationName(): string
    {
        return match ($this->specialization) {
            '1' => 'هندسة برمجيات',
            '2' => 'ذكاء اصطناعي',
            '3' => 'شبكات',
            '4' => 'عام',
            default => 'null',
        };
    }
}
