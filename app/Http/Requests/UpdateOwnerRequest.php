<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'no_wa' => 'sometimes|required|string|max:30',
            'alamat' => 'sometimes|required|string|max:500',
            'nama' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
        ];
    }
}
