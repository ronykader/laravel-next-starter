<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class AccountCreateRequest extends FormRequest
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
            'account_name' => ['required', 'string'],
            'account_number' => ['required', 'string'],
            'type' => ['required', 'string'],
            'account_status' => ['required', 'integer', 'between:0,1'],
            'balance' => ['required', 'integer', 'min:0'],
            'color' => ['nullable', 'string'],
        ];
    }
}
