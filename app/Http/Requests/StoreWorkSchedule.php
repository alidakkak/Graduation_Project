<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkSchedule extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'semester_id' => 'required|exists:semesters,id',
            'academic_level' => 'required|integer|min:1|max:5',
            'specialization' => 'nullable|string',

            'course_name' => 'required|array|min:1',
            'course_name.*' => 'required|string',

            'instructor_name' => 'required|array|size:'.count($this->input('course_name', [])),
            'instructor_name.*' => 'required|string',

            'day' => 'required|array|size:'.count($this->input('course_name', [])),
            'day.*' => 'required|string',

            'start_time' => 'required|array|size:'.count($this->input('course_name', [])),
            'start_time.*' => 'required|date_format:H:i',

            'end_time' => 'required|array|size:'.count($this->input('course_name', [])),
            'end_time.*' => 'required|date_format:H:i',

            'room' => 'required|array|size:'.count($this->input('course_name', [])),
            'room.*' => 'required|string',

            'branch' => 'nullable|array|size:'.count($this->input('course_name', [])),
            'branch.*' => 'nullable',
        ];
    }
}
