<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GoalTransactionCreateRequest extends FormRequest
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
            'type' => 'required|in:deposit,withdraw',
            'note' => 'nullable|string|max:255',
            'goal_id' => [
                'required',
                'exists:goals,id', // Ensure the goal exists in the database
                Rule::exists('goals', 'id')->where(function ($query) {
                    // Ensure the goal belongs to the authenticated user
                    return $query->where('user_id', auth()->id());
                }),
            ],
        ];
    }
    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'goal_id.exists' => 'The selected goal is invalid or does not belong to you.',
        ];
    }
}
