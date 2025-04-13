<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicAnnouncement extends FormRequest
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
            'title' => 'string|nullable',
            'description' => 'string|nullable',
            'images' => 'array|nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
}
