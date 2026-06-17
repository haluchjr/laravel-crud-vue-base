<?php

namespace Database\Factories;

use App\Models\Cadastro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class CadastroFactory extends Factory
{
    // Adicionado para garantir que o Laravel saiba qual model essa factory serve
    protected $model = Cadastro::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'         => $this->faker->name(),
            'email'        => $this->faker->unique()->safeEmail(),
            'ddd_telefone' => $this->faker->numerify('########'),
            'ddd_celular'  => $this->faker->numerify('########'),
            'cpf_cnpj'     => $this->faker->numerify('###########'),
            'cep'          => $this->faker->numerify('#####'),
            'endereco'     => $this->faker->streetAddress(), // Dica: streetAddress gera endereços reais!
            'nr'           => $this->faker->buildingNumber(), // Dica: buildingNumber gera números de casa reais
            'bairro'       => $this->faker->text(8),
            'cidade'       => $this->faker->city(), // Dica: city gera nomes de cidades reais
            'estado'       => strtoupper($this->faker->lexify('??')) // Gera 2 letras maiúsculas para o estado
        ];
    }
}
