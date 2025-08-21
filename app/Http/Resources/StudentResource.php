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
            'image' => url($this->image),
            'profileImage' => url($this->profileImage),
            'academic_year' => $this->getAcademicYearName($this->academic_year),
            'specialization' => $this->getSpecializationName($this->specialization),
            'verified' => $this->verified,
            'is_registration_complete' => $this->is_registration_complete,
        ];
    }

    private function getAcademicYearName(int $level): string
    {
        return match ($level) {
            1 => 'السنة الأولى',
            2 => 'السنة الثانية',
            3 => 'السنة الثالثة',
            4 => 'السنة الرابعة',
            5 => 'السنة الخامسة',
            default => 'غير معروفة',
        };
    }

    private function getSpecializationName(?int $code): string
    {
        return match ($code) {
            1 => 'هندسة برمجيات',
            2 => 'ذكاء اصطناعي',
            3 => 'شبكات',
            default => 'غير محدد',
        };
    }
}
