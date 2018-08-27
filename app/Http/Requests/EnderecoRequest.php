<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnderecoRequest extends FormRequest
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
            'cep'       => 'required|string|max:14',
            'cidade'    => 'required|string|max:30',
            'uf'        => 'required|string|max:2'

        ];
    }

    public function messages(){
        
        return [
            'cep.required' => 'Informe o CEP',
            'cidade.required' => 'Informe a Cidade',
            'uf.required' => 'Informe a Unidade Federal',
            'uf.max' => 'Informe somente a sigla da Unidade Federal'
        ];
        
    }
}
