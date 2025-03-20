<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    // Defina os campos que podem ser atribuídos em massa
    protected $fillable = ['nome_produto', 'quantidade', 'preco', 'preco_venda'];
}
