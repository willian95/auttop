<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetUpdateRequest extends FormRequest
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
            "services" => "required",
            "total" => "required|numeric"
        ];
    }

    public function messages()
    {
        return [
            'services.required' => 'Los servicios son requeridos',
            'total.required'  => 'El total es requerido',
            'total.numeric'  => 'El total debe ser numerico, letras no son admitidas',
        ];
    }
}
