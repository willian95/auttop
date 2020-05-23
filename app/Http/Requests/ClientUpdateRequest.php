<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "email" => "email|required",
            "telephone" => "required",
            "location" => "required",
            "address" => "required"
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'email.required'  => 'El email es requerido',
            'email.email'  => 'El email debe ser válido',
            'location.required'  => 'La comuna es requerida',
            'address.required'  => 'La dirección es requerida',
        ];
    }
}
