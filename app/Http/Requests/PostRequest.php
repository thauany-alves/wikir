<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'categoria_id' => 'required|numeric',
            'descricao' => 'required|max:255',
            'location' => 'required|string',
            'image'     => 'image',
        ];
    }

    public function messages(){
        
        return [
            'categoria_id.required' => 'Informe a categoria do problema',
            'location.required' => 'Informe a localização do problema',
            'descricao.required' => 'Informe a descrição problema',
            'image' => 'É necessário que o arquivo tenha formato de imagem',
        ];
        
    }
}
