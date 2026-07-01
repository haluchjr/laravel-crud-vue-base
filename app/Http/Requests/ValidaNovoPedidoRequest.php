<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ValidaNovoPedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'email'         => ['required', 'string', 'email', 'unique:tb_usuarios,email'],
            'ddd_telefone'  => ['required','digits:10'],
            'ddd_celular'   => ['required','digits:11'],
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
}
