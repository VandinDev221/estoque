<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrecoVendaToEstoquesTable extends Migration
{
    public function up()
    {
        Schema::table('estoques', function (Blueprint $table) {
            $table->decimal('preco_venda', 8, 2); // Adiciona a coluna 'preco_venda'
        });
    }

    public function down()
    {
        Schema::table('estoques', function (Blueprint $table) {
            $table->dropColumn('preco_venda'); // Remove a coluna 'preco_venda'
        });
    }
}
