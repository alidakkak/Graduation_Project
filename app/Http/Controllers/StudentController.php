<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function studentRegistration(StoreStudentRequest $request) {
        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);

            $student = Student::create($data);

            return response()->json([
                'message' => 'عليك الانتظار حتى يتم تأكيد حسابك',
                'student' => StudentResource::make($student)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء التسجيل',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getStudentNotRegistrationComplete() {
        $students = Student::where('is_registration_complete', 0)->get();
        return StudentResource::collection($students);
    }

    public function checkStudentData($studentID) {
        $student = Student::where('id', $studentID)->first();

        if(!$student) {
            return response()->json([
                'message' => 'لم يتم العثور على الطالب',
            ], 403);
        }

        $student->update([
            'is_registration_complete' => 1,
        ]);
        return response()->json([
           'message' => 'تم تحديث البيانات بنجاح',
           'student' => StudentResource::make($student)
        ], 200);
    }

    public function completeRegistration() {

    }
}
