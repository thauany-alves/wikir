<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'nivel'    => 'required',
            'avatar' =>     'image',
        ];
    }

    public function messages(){
        
        return [
            'name.required' => 'É necessário informar o nome de usuário',
            'nivel.required' => 'Informe o nível de acesso do usuário',
            'email.required' => 'É necessário informar um email',
            'password.required' => 'É necessário informar uma senha',
            'password.min'      => 'A senha deve conter no mínimo seis caracteres',
            'avatar.image' => 'O arquivo necessita está em formato de imagem',
        ];
        
    }
}
