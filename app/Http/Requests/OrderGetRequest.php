<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderGetRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna dapat melakukan request ini.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Ganti dengan kondisi autentikasi jika diperlukan
    }

    /**
     * Tentukan aturan validasi untuk request ini.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'nullable|string|in:pending,completed,cancelled',
            'customer_id' => 'nullable|exists:users,id',
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
            'status.in' => 'Status harus salah satu dari: pending, completed, cancelled.',
            'customer_id.exists' => 'Customer ID yang diberikan tidak valid.',
        ];
    }
}
