<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkSchedule;
use App\Http\Requests\UpdateWorkSchedule;
use App\Http\Resources\WorkScheduleResource;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkScheduleController extends Controller
{
    public function getSchedulesBySemesterID(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $schedules = WorkSchedule::where('semester_id', $request->semester_id)
            ->orderBy('academic_level')
            ->orderBy('specialization')
            ->orderByRaw("FIELD(day, 'الأحد','الاثنين','الثلاثاء','الأربعاء','الخميس')")
            ->orderBy('branch')
            ->orderBy('start_time')
            ->get();

        return (new WorkScheduleResource($schedules))->response();
    }

    public function store(StoreWorkSchedule $request)
    {
        try {
            DB::beginTransaction();

            $commonData = $request->only(['semester_id', 'academic_level', 'specialization']);
            $skipped = [];
            $validRows = [];

            $items = collect($request->input('course_name'))->map(function ($_, $index) use ($request, $commonData) {
                return [
                    'semester_id' => $commonData['semester_id'],
                    'academic_level' => $commonData['academic_level'],
                    'specialization' => $commonData['specialization'],
                    'course_name' => $request->course_name[$index],
                    'instructor_name' => $request->instructor_name[$index],
                    'day' => $request->day[$index],
                    'start_time' => $request->start_time[$index],
                    'end_time' => $request->end_time[$index],
                    'room' => $request->room[$index],
                    'branch' => $request->branch[$index],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            foreach ($items as $item) {
                $conflict = WorkSchedule::where('semester_id', $item['semester_id'])
                    ->where('day', $item['day'])
                    ->where(function ($query) use ($item) {
                        // تداخل الوقت للمدرّس
                        $query->orWhere(function ($q) use ($item) {
                            $q->where('instructor_name', $item['instructor_name'])
                                ->where(function ($q2) use ($item) {
                                    $q2->whereBetween('start_time', [$item['start_time'], $item['end_time']])
                                        ->orWhereBetween('end_time', [$item['start_time'], $item['end_time']]);
                                });
                        });

                        // تداخل الوقت لنفس القاعة
                        $query->orWhere(function ($q) use ($item) {
                            $q->where('room', $item['room'])
                                ->where(function ($q2) use ($item) {
                                    $q2->whereBetween('start_time', [$item['start_time'], $item['end_time']])
                                        ->orWhereBetween('end_time', [$item['start_time'], $item['end_time']]);
                                });
                        });
                    })
                    ->exists();

                if ($conflict) {
                    $skipped[] = [
                        'course_name' => $item['course_name'],
                        'instructor' => $item['instructor_name'],
                        'day' => $item['day'],
                        'start_time' => $item['start_time'],
                        'end_time' => $item['end_time'],
                        'room' => $item['room'],
                        'reason' => 'تعارض وقت مع مدرّس أو قاعة',
                    ];
                } else {
                    $validRows[] = $item;
                }
            }

            if (! empty($validRows)) {
                WorkSchedule::insert($validRows);
            }

            DB::commit();

            if (count($validRows) == 0) {
                return response()->json([
                    'message' => 'جميع الحصص غير صالحة للإضافة',
                    'skipped_conflicts' => $skipped,
                ], 422);
            }

            return response()->json([
                'message' => 'تمت إضافة الحصص الصالحة بنجاح.',
                'inserted_count' => count($validRows),
                'skipped_conflicts' => $skipped,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'حدث خطأ أثناء إدخال جدول الدوام.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateWorkSchedule $request, $id)
    {
        try {
            $schedule = WorkSchedule::findOrFail($id);

            $data = $request->only([
                'semester_id', 'academic_level', 'specialization',
                'course_name', 'instructor_name',
                'day', 'start_time', 'end_time', 'room',
            ]);

            // مزج البيانات القديمة مع الجديدة للتحقق من التعارض
            $checkData = [
                'semester_id' => $data['semester_id'] ?? $schedule->semester_id,
                'day' => $data['day'] ?? $schedule->day,
                'start_time' => $data['start_time'] ?? $schedule->start_time,
                'end_time' => $data['end_time'] ?? $schedule->end_time,
                'room' => $data['room'] ?? $schedule->room,
                'instructor_name' => $data['instructor_name'] ?? $schedule->instructor_name,
            ];

            $checkConflict = $request->hasAny(['start_time', 'end_time', 'day', 'room', 'instructor_name']);

            if ($checkConflict) {
                $conflict = WorkSchedule::where('id', '!=', $schedule->id)
                    ->where('semester_id', $checkData['semester_id'])
                    ->where('day', $checkData['day'])
                    ->where(function ($query) use ($checkData) {
                        $query->orWhere(function ($q) use ($checkData) {
                            $q->where('instructor_name', $checkData['instructor_name'])
                                ->where(function ($q2) use ($checkData) {
                                    $q2->whereBetween('start_time', [$checkData['start_time'], $checkData['end_time']])
                                        ->orWhereBetween('end_time', [$checkData['start_time'], $checkData['end_time']]);
                                });
                        });

                        $query->orWhere(function ($q) use ($checkData) {
                            $q->where('room', $checkData['room'])
                                ->where(function ($q2) use ($checkData) {
                                    $q2->whereBetween('start_time', [$checkData['start_time'], $checkData['end_time']])
                                        ->orWhereBetween('end_time', [$checkData['start_time'], $checkData['end_time']]);
                                });
                        });
                    })
                    ->exists();

                if ($conflict) {
                    return response()->json([
                        'message' => 'تعارض في وقت المدرّس أو القاعة',
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
                'message' => 'حدث خطأ أثناء تحديث الحصة.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
