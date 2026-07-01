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
        Schema::create('tb_pedidos', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('cliente_id');
            $table->foreignId('cliente_id')->constrained('tb_clientes');

            $table->text('descricao');
            $table->string('caminho_pdf')->comment('Caminho absoluto do pdf');
            $table->integer('validado')->comment('Pdf validado');
            $table->integer('boneco_aprovado')->comment('Se boneco foi ou nao aprovado');
            
            $table->decimal('valor_frete', 8, 2);
            $table->decimal('valor_pedido', 10, 2);

            $table->date('data_inclusao');
            $table->date('data_entrega');
            $table->timestamps();

        });

        Schema::create('tb_pedido_itens', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('pedido_id');
            $table->foreignId('pedido_id')->constrained('tb_pedido');

            $table->text('descricao');
            $table->string('caminho_pdf')->comment('Caminho absoluto do pdf');
            $table->integer('validado')->comment('Pdf validado');
            $table->integer('boneco_aprovado')->comment('Se boneco foi ou nao aprovado');
            
            $table->decimal('valor_unitario', 8, 2);

            $table->date('data_inclusao');
            $table->date('data_entrega');
            $table->timestamps();

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pedidos');
    }
};
