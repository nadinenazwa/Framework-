<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idpet' => 'sometimes|required|exists:pet,idpet',
            'idrole_user' => 'sometimes|required|exists:role_user,idrole_user',
            'waktu_daftar' => 'sometimes|required|date',
            'no_urut' => 'sometimes|nullable|integer',
            'status' => 'sometimes|required|string|max:50',
        ];
    }
}
