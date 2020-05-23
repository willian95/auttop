<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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
            "selectedCategory" => "required|integer"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Nombre es requerido",
            "selectedCategory.required" => "Debe seleccionar una categoría",
            "selectedCategory.integer" => "Categoría seleccionada debe ser válida"
        ];
    }
}
