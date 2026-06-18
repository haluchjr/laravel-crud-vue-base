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
            'email'         => ['required'],
            //'ddd_telefone'  => ['required'],
            //'ddd_celular'   => ['required'],
            //'cpf_cnpj'      => ['required'],
            //'cep'           => ['required'],
            //'endereco'      => ['required'],
            //'nr'            => ['required'],
            //'bairro'        => ['required'],
            //'cidade'        => ['required'],
            //'estado'        => ['required'],
            'foto' => [
                'nullable',        // Permite que o usuário não envie foto se não quiser
                'image',           // Garante que é um arquivo de imagem (jpeg, png, bmp, gif, svg, ou webp)
                'mimes:jpg,jpeg,png,webp', // Trava nos formatos de sua preferência
                'max:2048',        // Tamanho máximo do arquivo em Kilobytes (2048 KB = 2MB)
                
                // 💡 Validação de dimensões (pixels)
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
                
                // Alternativa se você quisesse uma imagem estritamente quadrada (ex: foto de perfil):
                // 'dimensions:ratio=1/1',
            ]
        ];
        
    }


    public function messages(): array
    {
        return [
                'nome.required'  => 'Ei! Você esqueceu de digitar o nome.',
                'email.required' => 'Falto email.',

                'foto.image' => 'O arquivo selecionado deve ser uma imagem.',
                'foto.mimes' => 'A imagem deve ser do tipo: JPG, JPEG, PNG ou WEBP.',
                'foto.max' => 'A imagem não pode ser maior que 2MB.',
                'foto.dimensions' => 'A imagem deve ter entre 100x100 e 2000x2000 pixels.',
            ];
    }


}//
