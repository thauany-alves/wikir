<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'password' => 'required|string|min:6|max:255',
            'avatar' =>     'image',
        ];
    }

    public function messages(){
        
        return [
            'name.required' => 'É necessário informar o nome de usuário',
            'password.required' => 'É necessário informar a senha de usuário',
            'password.min'      => 'A senha deve conter no mínimo seis caracteres',
            'avatar.image' => 'O arquivo necessita está em formato de imagem',
        ];
        
    }
}
