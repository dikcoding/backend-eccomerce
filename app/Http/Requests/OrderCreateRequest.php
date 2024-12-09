<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna dapat melakukan request ini.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; 
    }

    /**
     * Tentukan aturan validasi untuk request ini.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|exists:users,id',
            'status' => 'nullable|string|in:pending,completed,cancelled',
        ];
    }

    /**
     * Tentukan pesan validasi kustom.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'customer_id.required' => 'Customer ID harus diisi.',
            'customer_id.exists' => 'Customer ID yang diberikan tidak valid.',
            'status.in' => 'Status harus berupa salah satu dari: pending, completed, cancelled.',
        ];
    }
}
