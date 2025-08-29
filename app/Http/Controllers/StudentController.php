<?php

namespace App\Http\Controllers;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateProfileStudent;
use App\Http\Resources\StudentResource;
use App\Models\Conversation;
use App\Models\DeviceToken;
use App\Models\Notification;
use App\Models\Student;
use App\Models\Subject;
use App\Services\FirebaseService;
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
                'student' => ['id' => $student->id,
                    'full_name' => $student->first_name.' '.$student->father_name.' '.$student->last_name,
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'father_name' => $student->father_name,
                    'university_number' => $student->university_number, ],
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

        $tokens = DeviceToken::where('student_id', $student->id)
            ->pluck('device_token')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $title = 'تم تفعيل حسابك';
        $body = 'مرحبًا! تم تفعيل حسابك بنجاح. يمكنك الآن استخدام كل ميزات التطبيق.';

        Notification::create([
            'title' => $title,
            'body' => $body,
            'announcement_id' => $student->id,
            'academic_year' => null,
            'specialization' => null,
            'tokens_count' => count($tokens),
        ]);
        $firebase = app(FirebaseService::class);
        $firebase->BasicSendNotification(
            $title,
            $body,
            $tokens,
            [
                'student_id' => $student->id,
                'type' => 'account_activated',
            ]
        );

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
            return response()->json(['message' => 'يجب عليك الانتظار حتى يتم تفعيل حسابك'], 422);
        }

        $user = Auth::guard('api_student')->user();

        return response()->json([
            'user' => StudentResource::make($user),
            'token' => $token,
        ], 200);

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

        if ($validated['year']) {
            $conversationIdYear = Conversation::where('year_id', $validated['year'])->pluck('id')->toArray();
            $student->conversations()->sync($conversationIdYear);

        }
        if ($validated['specialization']) {
            $conversationIdYear = Conversation::where('specialization', $validated['specialization'])->pluck('id')->toArray();
            $student->conversations()->sync($conversationIdYear);

        }
        $student->conversations()->sync($conversationIds);

        return response()->json([
            'message' => 'Registration completed successfully',
        ]);

    }

    public function getSubject()
    {
        $subjects = Subject::select('id', 'name', 'year_id', 'specialization')->get();

        return ApiResponseHelper::sendResponse(new Result($subjects));
    }

    public function myProfile()
    {
        $user = Auth::guard('api_student')->user();

        return StudentResource::make($user);
    }

    public function updateProfile(UpdateProfileStudent $request, $studentID)
    {
        $validated = $request->validated();

        $student = Student::find($studentID);
        if (! $student) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        try {
            DB::beginTransaction();

            foreach (['first_name', 'last_name', 'father_name', 'academic_year', 'specialization', 'profileImage'] as $field) {
                if (array_key_exists($field, $validated)) {
                    $student->{$field} = $validated[$field];
                }
            }

            $student->save();

            $newSubjects = [];

            if (array_key_exists('academic_year', $validated) && array_key_exists('specialization', $validated)) {
                $autoSubjects = Subject::where('year_id', $validated['academic_year'])
                    ->where('specialization', $validated['specialization'])
                    ->pluck('id')
                    ->all();

                $newSubjects = array_merge($newSubjects, $autoSubjects);
            }

            if (! empty($validated['subjects'])) {
                $newSubjects = array_merge($newSubjects, $validated['subjects']);
            }

            $newSubjects = array_filter(array_unique(array_map('intval', $newSubjects)));

            if (! empty($newSubjects)) {
                $student->subjects()->syncWithoutDetaching($newSubjects);

                $conversationIds = Conversation::whereIn('subject_id', $newSubjects)
                    ->pluck('id')
                    ->all();
                if ($validated['academic_year']) {
                    $conversationIdYear = Conversation::where('year_id', $validated['academic_year'])->pluck('id')->toArray();
                    $student->conversations()->sync($conversationIdYear);

                }
                if ($validated['specialization']) {
                    $conversationIdYear = Conversation::where('specialization', $validated['specialization'])->pluck('id')->toArray();
                    $student->conversations()->sync($conversationIdYear);

                }
                if (! empty($conversationIds)) {
                    $student->conversations()->syncWithoutDetaching($conversationIds);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Updated Successfully',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
