<?php

namespace App\Http\Requests\v1;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFamilyMemberRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:25',
            'email' => [
                'required',
                'email',
                'unique:users,email',
                // Ensure email domain matches parent if needed
                function ($attribute, $value, $fail) {
                    if (config('app.require_family_email_domain')) {
                        $parentDomain = explode('@', $this->user()->email)[1];
                        if (!str_ends_with($value, '@'.$parentDomain)) {
                            $fail('Email must belong to family domain');
                        }
                    }
                }
            ],
            'status' => 'required|in:0,1',
            'password' => 'required|string|min:8',
//            'parent_id' => [
//                'required',
//                Rule::exists('users', 'id')->where(function ($query) {
//                    $query->where('role', 'main')
//                        ->where('id', $this->user()->id);
//                }),
//            ]
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
