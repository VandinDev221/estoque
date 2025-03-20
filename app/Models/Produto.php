<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    // Defina a tabela e os campos, caso o nome da tabela não siga a convenção (ex: produtos)
    protected $table = 'estoques';  // Se sua tabela se chama 'estoques'

    // Se necessário, defina os campos que são preenchíveis
    protected $fillable = ['nome_produto', 'quantidade', 'preco', 'preco_venda'];  // Ajuste conforme necessário
}
