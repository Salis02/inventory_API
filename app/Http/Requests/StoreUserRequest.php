<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|string|max:50|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,operator',
        ];
    }
    public function prepareForValidation()
    {
        if ($this->password) {
            $this->merge(['password' => bcrypt($this->password)]);
        }
    }
    }
