<?php

namespace App\Http\Requests\v1;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('user_id', auth()->id())
                        ->whereNull('parent_id');
                }),
            ],
            'icon' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'type' => ['required', Rule::in(['income', 'expense'])],
            'subcategories' => ['nullable', 'array'],
            'subcategories.*.name' => ['required', 'string', 'max:255'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $subcategories = $this->input('subcategories', []);
            $userId = auth()->id();
            $seenNames = [];

            foreach ($subcategories as $index => $subcategory) {
                $name = $subcategory['name'] ?? null;

                if (in_array($name, $seenNames)) {
                    $validator->errors()->add("subcategories.$index.name", "Subcategory name '$name' is duplicated in this request.");
                } else {
                    $seenNames[] = $name;
                }

                $exists = \App\Models\Category::where('user_id', $userId)
                    ->where('name', $name)
                    ->whereNotNull('parent_id')
                    ->exists();

                if ($exists) {
                    $validator->errors()->add("subcategories", "Subcategory name '$name' already exists for this user.");
                }
            }
        });
    }

    public function messages()
    {
        return [
            'name' => 'The category name is already exist.',
            'type.in' => 'Type must be income, expense.'
        ];
    }
}
