<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends BaseRequest
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
            'name' => 'required|string|max:100', 
            'description' => 'nullable|string|max:500',
            'sheet_id' => 'required|string|max:30',
        ];
    }

    /**
     * Customize the error messages for the validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'The title field is mandatory.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title may not be greater than 100 characters.',
            'description.string' => 'The description must be a valid string.',
            'description.max' => 'The description may not be greater than 500 characters.',
            'sheet_id.max' => 'The sheet id may not be greater than 100 characters.',
            'sheet_id.required' => 'The sheet id field is mandatory.',
        ];
    }
}
