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
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_fabricacao');
            $table->dateTime('data_validade');
            $table->dateTime('data_entrada');
            $table->float('preco_custo_unitario');
            $table->unsignedBigInteger('produto_id');
            $table->foreign('produto_id')->on('produtos')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->on('users')->references('id');
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
        Schema::dropIfExists('lotes');
    }
};
