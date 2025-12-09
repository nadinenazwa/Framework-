<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'warna_tanda' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:J,B',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'nullable|exists:ras_hewan,idras_hewan',
        ];
    }
}
