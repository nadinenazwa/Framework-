<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'no_wa' => 'required|string|max:30',
            'alamat' => 'required|string|max:500',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];
    }
}
