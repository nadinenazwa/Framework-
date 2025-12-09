<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'sometimes|required|string|max:255',
            'tanggal_lahir' => 'sometimes|nullable|date',
            'warna_tanda' => 'sometimes|nullable|string|max:255',
            'jenis_kelamin' => 'sometimes|required|in:J,B',
            'idpemilik' => 'sometimes|required|exists:pemilik,idpemilik',
            'idras_hewan' => 'sometimes|nullable|exists:ras_hewan,idras_hewan',
        ];
    }
}
