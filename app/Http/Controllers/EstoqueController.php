<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    // Mostrar a lista de produtos
    public function index(Request $request)
    {
        $search = $request->input('search'); // Pega o termo de busca
    
        $produtos = Produto::when($search, function($query, $search) {
            return $query->where('nome_produto', 'like', "%{$search}%");
        })->get(); // Filtra os produtos com base no nome
    
        return view('estoque.index', compact('produtos', 'search'));
    }    

    // Retornar lista de produtos em formato JSON
    public function getProdutos()
    {
        $produtos = Produto::all()->map(function ($produto) {
            return [
                'id' => $produto->id,
                'nome_produto' => $produto->nome_produto,
                'quantidade' => $produto->quantidade,
                'preco_venda' => number_format($produto->preco_venda, 2, ',', '.'),
            ];
        });

        return response()->json(['produtos' => $produtos]);
    }

    // Exibir formulário para adicionar produto
    public function create()
    {
        return view('estoque.create');
    }

    // Salvar novo produto no estoque
    public function store(Request $request)
    {
        $request->validate([
            'nome_produto' => 'required|string|max:255',
            'quantidade' => 'required|integer',
            'preco' => 'required|numeric',
            'preco_venda' => 'required|numeric',
        ]);

        Produto::create([
            'nome_produto' => $request->nome_produto,
            'quantidade' => $request->quantidade,
            'preco' => $request->preco,
            'preco_venda' => $request->preco_venda,
        ]);

        return redirect()->route('estoque.index');
    }

    // Editar um produto existente
    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('estoque.edit', compact('produto'));
    }

    // Atualizar os dados de um produto
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome_produto' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'preco' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
        ]);

        $produto = Produto::findOrFail($id);
        $produto->update($request->all());

        return redirect()->route('estoque.index')->with('success', 'Produto atualizado com sucesso!');
    }

    // Excluir um produto
    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return redirect()->route('estoque.index')->with('success', 'Produto excluído com sucesso!');
    }

public function updateQuantity(Request $request, $id)
{
    $produto = Produto::findOrFail($id);

    if ($request->action === 'increase') {
        $produto->quantidade += 1;
    } elseif ($request->action === 'decrease' && $produto->quantidade > 0) {
        $produto->quantidade -= 1;
    }

    $produto->save();

    return redirect()->route('estoque.index')->with('success', 'Quantidade atualizada com sucesso!');
}

}
