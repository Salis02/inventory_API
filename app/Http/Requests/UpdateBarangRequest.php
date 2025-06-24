<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
            'nama' => 'sometimes|required|string|max:100',
            'kode' => 'sometimes|required|string|max:50|unique:barangs,kode,' . $this->barang->id,
            'stok' => 'sometimes|required|integer|min:0',
            'lokasi_rak' => 'nullable|string|max:100',
        ];
    }
}
