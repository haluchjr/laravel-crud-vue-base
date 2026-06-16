<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cadastro', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('ddd_telefone',9);
            $table->string('ddd_celular',2);
            $table->string('cpf_cnpj',15)->unique();
            $table->string('cep',8);
            $table->string('endereco');
            $table->string('nr', 11);
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado',2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
