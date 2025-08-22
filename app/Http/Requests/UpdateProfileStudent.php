<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileStudent extends FormRequest
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
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'father_name' => 'sometimes|string',
            'profileImage' => 'sometimes|image|mimes:jpeg,png,jpg,svg|max:2048',
            'academic_year' => 'sometimes',
            'specialization' => 'sometimes',
            'subjects' => 'sometimes|array',
            'subjects.*' => 'int|exists:subjects,id',
        ];
    }
}
