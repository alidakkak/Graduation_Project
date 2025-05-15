<?php

namespace App\Http\Controllers;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Conversation;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function studentRegistration(StoreStudentRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);

            $student = Student::create($data);

            $student->deviceTokens()->create([
                'device_token' => $data['deviceToken'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'عليك الانتظار حتى يتم تأكيد حسابك',
                'student' => StudentResource::make($student),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'حدث خطأ أثناء التسجيل',
                'error' => $e->getMessage(),
            ], 500);
        }
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

    public function login(Request $request)
    {
        $request->validate([
            'university_number' => 'required|numeric',
            'password' => 'required|string',
            'device_token' => 'required|string',
        ]);

        $credentials = $request->only('university_number', 'password');

        $token = Auth::guard('api_student')->attempt($credentials);
        if (! $token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $student = Student::where('university_number', $request->university_number)
            ->where('verified', '!=', 1)
            ->first();
        if ($student) {
            return response()->json(['message' => 'يجب عليك الانتظار حتى يتم تفعيل حسابك']);
        }

        $user = Auth::guard('api_student')->user();

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);

    }

    public function studentRegistrationComplete(Student $student, Request $request)
    {
        $validated = $request->validate([
            'year' => 'required',
            'specialization' => 'required',
            'subjects' => 'required|array',
            'subjects.*' => 'int|exists:subjects,id',
        ]);

        $validated['subjects'] = array_unique($validated['subjects']);

        $student->update([
            'is_registration_complete' => 1,
            'academic_year' => $validated['year'],
            'specialization' => $validated['specialization'],
        ]);

        $subjects = Subject::where('year_id', $validated['year'])
            ->where('specialization', $validated['specialization'])
            ->pluck('id')
            ->toArray();
        $subjects = array_merge($subjects, $validated['subjects']);
        $subjects = array_map('intval', $subjects);
        $subjects = array_unique($subjects);
        $subjects = array_values($subjects);

        $student->subjects()->sync($subjects);

        $conversationIds = Conversation::whereIn('subject_id', $subjects)->pluck('id')->toArray();

        $student->conversations()->sync($conversationIds, ['joined_at' => now()]);

        return response()->json([
            'message' => 'Registration completed successfully',
        ]);

    }

    public function getSubject()
    {
        $subjects = Subject::select('id', 'name', 'year_id', 'specialization')->get();

        return ApiResponseHelper::sendResponse(new Result($subjects));
    }
}
