<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            "rut" => "required",
            "name" => "required",
            "telephone"=> "required",
            "address"=> "required",
            "patent"=> "required",
            "brand"=> "required",
            "year"=> "required|integer",
            "model"=> "required",
            "services"=> "required",
            "delivery" => "required|integer"
        ];
    }

    public function messages()
    {
        return [
            'rut.required' => 'El rut es requerido',
            'name.required'  => 'El nombre es requerido',
            'telephone.required'  => 'El teléfono es requerido',
            'address.required'  => 'La dirección es requerida',
            'location.required'  => 'La comuna es requerida',
            'email.required'  => 'El email es requerido',
            'email.email'  => 'El email debe ser válido',
            'patent.required' => 'La patente es requerida',
            'brand.required' => "La marca es requerida",
            "year.required" => "El año es requerido",
            "year.integer" => "El año debe ser un número entero, sin decimales ni letras",
            "model.required" => "El modelo es requerido",
            "color.required" => "El color es requerido",
            "Kilometers.required" => "Los kilometros son requeridos",
            "kilometers.integer" => "Los kilomteros debe ser un número entero, sin decimales ni letras",
            "gas_amount.required" => "La cantidad de combustible es requerida",
            "gas_amount.integer" => "Debe elegir la cantidad de combustible",
            "comments.required" => "Los comentarios son requeridos",
            "services.required" => "Los servicios son requeridos",
            "mechanic.required" => "Debe seleccionar un mecánico",
            "mechanic.integer" => "Mecánico seleccionado no es válido"

        ];
    }
}
