<?php

namespace App\Http\Requests\v1;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFamilyMemberRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:25',
            'status' => 'required|in:0,1',
        ];
    }
    public function messages()
    {
        return [
            'parent_id.exists' => 'The selected parent is invalid or you don\'t have permission',
            'email.unique' => 'This email is already registered'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'parent_id' => $this->user()->id,
        ]);
    }
}
