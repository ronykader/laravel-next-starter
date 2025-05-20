<?php

namespace App\Http\Requests\v1;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'icon' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'type' => ['required', Rule::in(['income', 'expense'])],
            'subcategories' => ['nullable', 'array'],
            'subcategories.*.id' => ['nullable', 'max:255'],
            'subcategories.*.name' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name' => 'The category name is already exist.',
            'type.in' => 'Type must be income, expense.'
        ];
    }
}
