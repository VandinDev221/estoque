<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrecoToEstoquesTable extends Migration
{
    public function up()
    {
        Schema::table('estoques', function (Blueprint $table) {
            $table->decimal('preco', 8, 2);  // Adiciona a coluna 'preco'
        });
    }

    public function down()
    {
        Schema::table('estoques', function (Blueprint $table) {
            $table->dropColumn('preco');  // Remove a coluna 'preco'
        });
    }
}
