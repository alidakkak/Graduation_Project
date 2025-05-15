<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExamSchedule;
use App\Http\Requests\UpdateExamSchedule;
use App\Http\Resources\ExamScheduleResource;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamScheduleController extends Controller
{
    public function getSchedulesBySemesterID(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $schedules = ExamSchedule::where('semester_id', $request->semester_id)
            ->orderBy('academic_level')
            ->orderBy('specialization')
            ->orderBy('date')
            ->orderByRaw("FIELD(day, 'الأحد','الاثنين','الثلاثاء','الأربعاء','الخميس')")
            ->orderBy('start_time')
            ->get();

        return (new ExamScheduleResource($schedules))->response();
    }

    public function store(StoreExamSchedule $request)
    {
        try {
            DB::beginTransaction();

            $commonData = $request->only(['semester_id', 'academic_level', 'specialization']);
            $skipped = [];
            $validRows = [];

            $items = collect($request->input('subject_name'))->map(function ($_, $index) use ($request, $commonData) {
                return [
                    'semester_id' => $commonData['semester_id'],
                    'academic_level' => $commonData['academic_level'],
                    'specialization' => $commonData['specialization'],
                    'subject_name' => $request->subject_name[$index],
                    'day' => $request->day[$index],
                    'date' => $request->date[$index],
                    'start_time' => $request->start_time[$index],
                    'end_time' => $request->end_time[$index],
                    'status' => $request->status[$index],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            foreach ($items as $item) {
                $conflict = ExamSchedule::where('semester_id', $item['semester_id'])
                    ->where('date', $item['date'])
                    ->where(function ($q) use ($item) {
                        $q->whereBetween('start_time', [$item['start_time'], $item['end_time']])
                            ->orWhereBetween('end_time', [$item['start_time'], $item['end_time']]);
                    })
                    ->exists();

                if ($conflict) {
                    $skipped[] = [
                        'subject_name' => $item['subject_name'],
                        'day' => $item['day'],
                        'date' => $item['date'],
                        'start_time' => $item['start_time'],
                        'end_time' => $item['end_time'],
                        'status' => $item['status'],
                        'reason' => 'تعارض في الوقت',
                    ];
                } else {
                    $validRows[] = $item;
                }
            }

            if (! empty($validRows)) {
                ExamSchedule::insert($validRows);
            }

            DB::commit();

            if (count($validRows) == 0) {
                return response()->json([
                    'message' => 'جميع المواد غير صالحة للإضافة',
                    'skipped_conflicts' => $skipped,
                ], 422);
            }

            return response()->json([
                'message' => 'تمت إضافة المواد الصالحة بنجاح.',
                'inserted_count' => count($validRows),
                'skipped_conflicts' => $skipped,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'حدث خطأ أثناء إدخال جدول الإمتحان.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateExamSchedule $request, $id)
    {
        try {
            $schedule = ExamSchedule::findOrFail($id);

            $data = $request->only([
                'semester_id', 'academic_level', 'specialization',
                'subject_name',
                'day', 'date', 'start_time', 'end_time', 'status',
            ]);

            $checkData = [
                'semester_id' => $data['semester_id'] ?? $schedule->semester_id,
                'day' => $data['day'] ?? $schedule->day,
                'date' => $data['date'] ?? $schedule->date,
                'start_time' => $data['start_time'] ?? $schedule->start_time,
                'end_time' => $data['end_time'] ?? $schedule->end_time,
            ];

            $checkConflict = $request->hasAny(['start_time', 'end_time', 'data']);

            if ($checkConflict) {
                $conflict = ExamSchedule::where('id', '!=', $schedule->id)
                    ->where('semester_id', $checkData['semester_id'])
                    ->where('date', $checkData['date'])
                    ->where(function ($q) use ($checkData) {
                        $q->whereBetween('start_time', [$checkData['start_time'], $checkData['end_time']])
                            ->orWhereBetween('end_time', [$checkData['start_time'], $checkData['end_time']]);
                    })
                    ->exists();

                if ($conflict) {
                    return response()->json([
                        'message' => 'تعارض في الوقت',
                    ], 422);
                }
            }

            $schedule->update($data);

            return response()->json([
                'message' => 'تم تحديث الحصة بنجاح.',
                'data' => $schedule,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء التحديث .',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
