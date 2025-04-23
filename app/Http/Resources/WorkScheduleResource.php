<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $items = collect($this->resource);

        $result = [];

        foreach ($items as $item) {
            $yearName = $this->getAcademicYearName($item->academic_level);

            if (in_array($item->academic_level, [1, 2, 3])) {
                $result[$yearName][] = $this->formatSchedule($item);
            }

            elseif (in_array($item->academic_level, [4, 5])) {
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
            'course_name'     => $item->course_name,
            'instructor_name' => $item->instructor_name,
            'day'             => $item->day,
            'start_time'      => $item->start_time,
            'end_time'        => $item->end_time,
            'room'            => $item->room,
        ];
    }
}
