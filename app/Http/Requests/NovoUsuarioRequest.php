<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NovoUsuarioRequest extends FormRequest
{
    
    // Sempre deixe como true para permitir o uso
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'          => ['required'],
            //'email'         => ['required'],
            //'ddd_telefone'  => ['required'],
            //'ddd_celular'   => ['required'],
            //'cpf_cnpj'      => ['required'],
            //'cep'           => ['required'],
            //'endereco'      => ['required'],
            //'nr'            => ['required'],
            //'bairro'        => ['required'],
            //'cidade'        => ['required'],
            //'estado'        => ['required'],
        ];
        
    }


    public function messages(): array
    {
        return [
                'nome.required'  => 'Ei! Você esqueceu de digitar o nome.',
            ];
    }


}//
