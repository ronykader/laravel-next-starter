<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
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
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'sub_category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
                function ($attribute, $value, $fail) {
                    $categoryId = request('category_id');

                    if ($value == $categoryId) {
                        return $fail('The sub-category must be different from the category.');
                    }

                    $isValid = DB::table('categories')
                        ->where('id', $value)
                        ->where('parent_id', $categoryId)
                        ->exists();

                    if (! $isValid) {
                        $fail('The selected sub-category does not belong to the specified category.');
                    }
                }
            ],
            'amount' => ['required', 'numeric', 'min:1'],
            'transaction_date' => ['required', 'date', 'date_format:Y-m-d'],
            'type' => ['required', Rule::in(['income', 'expense', 'transfer'])],
            'note' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['completed', 'draft'])],
            'images' => 'nullable|array|max:4',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:100',
        ];

    }
}
