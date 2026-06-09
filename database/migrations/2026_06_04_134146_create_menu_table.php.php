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
        Schema::create('menus', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('url')->default('#');
        $table->string('icon')->nullable();
        $table->integer('ordem')->default(0); // Para ordenar o que vem primeiro
        
        // Relacionamento com o nível de acesso (pode ser string ou chave estrangeira da sua ACL)
        $table->string('nivel_permissao')->default('usuario'); // 'usuario', 'admin', etc.

        // 🪄 A MÁGICA RECURSIVA: Chave estrangeira para ela mesma!
        // nullable() significa que se for NULL, é um menu principal (SISTEMA, PEDIDOS)
        $table->foreignId('menu_pai_id')
              ->nullable()
              ->constrained('menus')
              ->onDelete('cascade'); 

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
