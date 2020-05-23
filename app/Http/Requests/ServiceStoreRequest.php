<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
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
            "categoryId" => "required|integer"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Campo nombre es requerido",
            "categoryId.required" => "Debe seleccionar una categoría",
            "categoryId.integer" => "Categoría seleccionada no es válida"
        ];
    }
}
