<?php

namespace App\Http\Requests;

use App\Models\Usuarios;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NovoUsuarioRequest extends FormRequest
{
    
    // Sempre deixe como true para permitir o uso
    public function authorize(): bool
    {
        return true;
    }


    // Sanitizar antes.
    protected function prepareForValidation()
    {
        $camposParaLimpar = ['ddd_telefone', 'ddd_celular', 'cpf_cnpj'];
        $dadosLimpos = [];

        foreach ($camposParaLimpar as $campo) {
            if ($this->has($campo)) {
                // preg_replace('/\D/', ...) remove absolutamente tudo que não for número (0-9)
                $dadosLimpos[$campo] = preg_replace('/\D/', '', $this->{$campo});
            }
        }

        // Faz o merge dos dados limpos de volta na Request
        $this->merge($dadosLimpos);

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


    /**
     * Se a validação falhar, intercepta e dá um dd nos erros
     */
    protected function failedValidation(Validator $validator)
    {
        // Mostra os erros de validação e os dados que tentaram ser validados
        dd([
            'erros' => $validator->errors()->toArray(),
            'dados_recebidos' => $this->all()
        ]);
    }


}//
