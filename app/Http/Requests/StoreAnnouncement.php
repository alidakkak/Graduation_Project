<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncement extends FormRequest
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
            'title' => 'string|required',
            'description' => 'string|required',
            'academic_year' => 'required|in:1,2,3,4,5,6',
            'specialization' => 'required|in:1,2,3,4',
            'images' => 'array|nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
}
