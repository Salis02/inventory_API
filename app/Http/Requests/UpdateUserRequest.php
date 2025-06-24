<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|string|max:50|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'sometimes|required|in:admin,operator',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->password) {
            $this->merge(['password' => bcrypt($this->password)]);
        } else {
            $this->request->remove('password');
        }
    }
}
