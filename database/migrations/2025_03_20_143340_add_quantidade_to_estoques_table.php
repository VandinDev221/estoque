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
            $table->integer('quantidade')->default(0); // Adiciona a coluna quantidade
        });
    }
    
    public function down()
    {
        Schema::table('estoques', function (Blueprint $table) {
            $table->dropColumn('quantidade'); // Remove a coluna se for necessário reverter a migração
        });
    }
    
};
