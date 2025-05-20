<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class GoalUpdateRequest extends FormRequest
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
            'name' => ['required','string'],
            'target_amount' => ['required', 'numeric'],
            'current_amount' => ['required', 'numeric'],
            'target_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'status' => ['required','string'],
        ];
    }
}
