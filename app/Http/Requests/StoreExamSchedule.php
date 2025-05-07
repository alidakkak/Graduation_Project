<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamSchedule extends FormRequest
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

            'subject_name' => 'required|array|min:1',
            'subject_name.*' => 'required|string',

            'day' => 'required|array|size:'.count($this->input('subject_name', [])),
            'day.*' => 'required|string',

            'date' => 'required|array|size:'.count($this->input('subject_name', [])),
            'date.*' => 'required|string',

            'start_time' => 'required|array|size:'.count($this->input('subject_name', [])),
            'start_time.*' => 'required|date_format:H:i',

            'end_time' => 'required|array|size:'.count($this->input('subject_name', [])),
            'end_time.*' => 'required|date_format:H:i',

            'status' => 'required|array|size:'.count($this->input('subject_name', [])),
            'status.*' => 'required|bool',
        ];
    }
}
