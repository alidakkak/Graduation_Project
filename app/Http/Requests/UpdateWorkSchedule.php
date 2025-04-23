<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkSchedule extends FormRequest
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
            'semester_id'      => 'sometimes|exists:semesters,id',
            'academic_level'   => 'sometimes|integer|min:1|max:5',
            'specialization'   => 'nullable|string',

            'course_name'      => 'sometimes|string',
            'instructor_name'  => 'sometimes|string',
            'day'              => 'sometimes|string',
            'start_time'       => 'sometimes|date_format:H:i',
            'end_time'         => 'sometimes|date_format:H:i|after:start_time',
            'room'             => 'sometimes|string',
        ];
    }
}
