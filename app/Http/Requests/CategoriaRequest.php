<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
            'nome' => 'required|min:4|max:100|string',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'É necessário informar a categoria',
            'nome.min' => 'É necessário informar um nome maior',
            'nome.max' => 'É necessário informar um nome menor',
        ];
    }
}
