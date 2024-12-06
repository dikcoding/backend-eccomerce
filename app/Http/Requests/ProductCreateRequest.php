<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductCreateRequest extends FormRequest
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
     * @return array<string, 
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'brand' => 'required|string|max:255',
            'berat' => 'numeric',
            'satuan' => 'string|max:50',
            'deskripsi' => 'string',
            'foto' => 'string',
            'user_id' => 'required|exists:categories,id',
            // 'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     */

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
