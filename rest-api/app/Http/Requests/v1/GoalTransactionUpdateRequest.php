<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GoalTransactionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
            'type' => ['required', Rule::in(['deposit', 'withdraw'])],
            'note' => 'nullable|string|max:255',
            'goal_id' => 'required|exists:goals,id,user_id,' . auth()->id(), // Ensuring goal_id exists and belongs to the authenticated user
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 1.',
            'type.required' => 'The type field is required.',
            'type.in' => 'The type must be either deposit or withdraw.',
            'note.string' => 'The note must be a string.',
            'note.max' => 'The note may not be greater than 255 characters.',
            'goal_id.required' => 'The goal ID is required.',
            'goal_id.exists' => 'The selected goal ID is invalid or does not belong to you.',
        ];
    }
}
