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
        Schema::table('estoques', function (Blueprint $table) {
            $table->string('nome_produto');  // Adiciona a coluna nome_produto
        });
    }
    
    public function down()
    {
        Schema::table('estoques', function (Blueprint $table) {
            $table->dropColumn('nome_produto');  // Remove a coluna nome_produto caso a migração seja revertida
        });
    }
    
};
