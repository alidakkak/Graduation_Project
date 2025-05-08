<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = collect($this->resource);

        $result = [];

        foreach ($items as $item) {
            $yearName = $this->getAcademicYearName($item->academic_level);

            if (in_array($item->academic_level, [1, 2, 3])) {
                $result[$yearName][] = $this->formatSchedule($item);
            } elseif (in_array($item->academic_level, [4, 5])) {
                $specializationName = $this->getSpecializationName($item->specialization);
                $result[$yearName][$specializationName][] = $this->formatSchedule($item);
            }
        }

        return $result;
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

    private function formatSchedule($item): array
    {
        return [
            'id' => $item->id,
            'subject_name' => $item->subject_name,
            'day' => $item->day,
            'date' => $item->date,
            'start_time' => $item->start_time->format('H:i'),
            'end_time' => $item->end_time->format('H:i'),
            'status' => $item->status,
        ];
    }
}
