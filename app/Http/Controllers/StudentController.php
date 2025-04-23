<?php

namespace App\Http\Controllers;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;

class StudentController extends Controller
{
    public function studentRegistration(StoreStudentRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);

            $student = Student::create($data);

            return response()->json([
                'message' => 'عليك الانتظار حتى يتم تأكيد حسابك',
                'student' => StudentResource::make($student),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء التسجيل',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getStudentNotRegistrationComplete()
    {
        $students = Student::paginate();
        $pagination = [
            'total' => $students->total(),
            'current_page' => $students->currentPage(),
            'last_page' => $students->lastPage(),
            'per_page' => $students->perPage(),
        ];
        $students = StudentResource::collection($students);

        return ApiResponseHelper::sendResponseWithPagination(new Result($students, 'get employees successfully', $pagination));

    }

    public function checkStudentData($studentID)
    {
        $student = Student::where('id', $studentID)->first();

        if (! $student) {
            return response()->json([
                'message' => 'لم يتم العثور على الطالب',
            ], 403);
        }

        $student->update([
            'verified' => ! $student->verified,
        ]);

        return response()->json([
            'message' => 'تم تحديث البيانات بنجاح',
            'student' => StudentResource::make($student),
        ], 200);
    }

    public function completeRegistration() {}
}
