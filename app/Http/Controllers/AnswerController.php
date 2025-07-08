<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\AnswerResource;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;

class AnswerController extends Controller
{
    /**
     * عرض جميع الإجابات لسؤال معين.
     */
    public function index(Request $request,Question $question)
    {
        $answers = $question->answers()->latest()->paginate(10);

        $pagination = [
            'total' => $answers->total(),
            'current_page' => $answers->currentPage(),
            'last_page' => $answers->lastPage(),
            'per_page' => $answers->perPage(),
        ];

        return ApiResponseHelper::sendResponseWithPagination(
            new Result(AnswerResource::collection($answers->items()), 'Get answers', $pagination)
        );
    }

    /**
     * تخزين إجابة جديدة.
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
        ]);
        $question = Question::findOrFail($request->questionId);
        $answer = $question->answers()->create([
            'body' => $request->body,
            'student_id' => auth('api_student')->id(),
        ]);

        return new AnswerResource($answer);
    }

    /**
     * عرض إجابة واحدة.
     */
    public function show($id)
    {
        $answer = Answer::findOrFail($id);
        return new AnswerResource($answer);
    }

    /**
     * تحديث إجابة.
     */
    public function update(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);

        if ($answer->student_id !== auth('api_student')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'body' => 'required|string',
        ]);

        $answer->update([
            'body' => $request->body,
        ]);

        return new AnswerResource($answer);
    }

    public function check($id)
    {
        $answer = Answer::findOrFail($id);

        // التأكد من أن الطالب هو صاحب السؤال
        if ($answer->question->student_id !== auth('api_student')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // تحديث قيمة check (قلب القيمة من true إلى false أو العكس)
        $answer->update([
            'check' => !$answer->check,
        ]);

        return new AnswerResource($answer);
    }



    /**
     * حذف إجابة.
     */
    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);

        if ($answer->student_id !== auth('api_student')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $answer->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
