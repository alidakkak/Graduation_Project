<?php

namespace App\Http\Controllers;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Question::query();

        $keyword = $request->string('keyword')->trim();
        if ($keyword->isNotEmpty()) {
            $kw = "%{$keyword}%";
            $query->where(function ($q) use ($kw) {
                $q->where('title', 'like', $kw)
                    ->orWhere('body', 'like', $kw);
            });
        }

        $questions = $query
            ->withCount('answers')
            ->latest()
            ->paginate(10);

        $pagination = [
            'total'        => $questions->total(),
            'current_page' => $questions->currentPage(),
            'last_page'    => $questions->lastPage(),
            'per_page'     => $questions->perPage(),
        ];

        return ApiResponseHelper::sendResponseWithPagination(
            new Result(
                QuestionResource::collection($questions->items()),
                'get questions',
                $pagination
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        $data = $request->validated();
        $data = array_merge($data, ['student_id' => auth('api_student')->id()]);
        $question = Question::create($data);

        return new QuestionResource($question);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::findOrFail($id);

        return new QuestionResource($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, string $id)
    {
        $question = Question::findOrFail($id);

        // Optional: authorize user
        if ($question->student_id !== auth('api_student')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $question->update($request->validated());

        return new QuestionResource($question);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);

        if ($question->student_id !== auth('api_student')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $question->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
