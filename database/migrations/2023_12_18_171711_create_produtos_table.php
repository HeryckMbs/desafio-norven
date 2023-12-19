<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo')->unique();
            $table->text('descricao');


            $table->float('preco_custo');
            $table->float('preco_venda');
            $table->string('unidade_medida');
            $table->unsignedBigInteger('fornecedor_id');
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('created_by');

            $table->foreign('fornecedor_id')->on('fornecedors')->references('id');
            $table->foreign('marca_id')->on('marcas')->references('id');
            $table->foreign('categoria_id')->on('categorias')->references('id')->onDelete('cascade');
            $table->foreign('created_by')->on('users')->references('id');
            
            $table->text('informacao_nutricional');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
