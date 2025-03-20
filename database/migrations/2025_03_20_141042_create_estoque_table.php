<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('estoque', function (Blueprint $table) {
            $table->id();
            $table->string('nome_produto');
            $table->text('descricao')->nullable();
            $table->integer('quantidade');
            $table->decimal('preco', 10, 2);
            $table->decimal('preco_venda', 10, 2);
            $table->timestamps();
        });
    }
    
};
