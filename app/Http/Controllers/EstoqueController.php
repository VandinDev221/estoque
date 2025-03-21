<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    // Mostrar a lista de produtos
    public function index(Request $request)
    {
        // Pega o termo de busca da requisição
        $search = $request->input('search'); 
    
        // Filtra os produtos pela busca e ordena os resultados pela quantidade (do menor para o maior)
        $produtos = Produto::when($search, function($query, $search) {
            // Se o termo de busca for fornecido, filtra os produtos pelo nome
            return $query->where('nome_produto', 'like', "%{$search}%");
        })
        ->orderBy('quantidade', 'asc') // Ordena os produtos pela quantidade (menor para maior)
        ->get(); // Obtém todos os produtos filtrados e ordenados
    
        // Retorna a view com os produtos e o termo de busca
        return view('estoque.index', compact('produtos', 'search'));
    }    

    // Retornar lista de produtos em formato JSON
    public function getProdutos()
    {
        // Mapeia os produtos para um formato JSON simples
        $produtos = Produto::all()->map(function ($produto) {
            return [
                'id' => $produto->id,
                'nome_produto' => $produto->nome_produto,
                'quantidade' => $produto->quantidade,
                'preco_venda' => number_format($produto->preco_venda, 2, ',', '.'), // Formata o preço para exibição
            ];
        });

        // Retorna os produtos no formato JSON
        return response()->json(['produtos' => $produtos]);
    }

    // Exibir formulário para adicionar produto
    public function create()
    {
        // Retorna a view para criar um novo produto
        return view('estoque.create');
    }

    // Salvar novo produto no estoque
    public function store(Request $request)
    {
        // Valida os dados recebidos do formulário
        $request->validate([
            'nome_produto' => 'required|string|max:255', // Nome do produto é obrigatório e deve ser uma string
            'quantidade' => 'required|integer', // A quantidade deve ser um número inteiro
            'preco' => 'required|numeric', // O preço de custo deve ser numérico
            'preco_venda' => 'required|numeric', // O preço de venda deve ser numérico
        ]);

        // Cria um novo produto com os dados do formulário
        Produto::create([
            'nome_produto' => $request->nome_produto,
            'quantidade' => $request->quantidade,
            'preco' => $request->preco,
            'preco_venda' => $request->preco_venda,
        ]);

        // Redireciona para a página de estoque com sucesso
        return redirect()->route('estoque.index');
    }

    // Editar um produto existente
    public function edit($id)
    {
        // Encontra o produto pelo ID
        $produto = Produto::findOrFail($id);

        // Retorna a view de edição com os dados do produto
        return view('estoque.edit', compact('produto'));
    }

    // Atualizar os dados de um produto
    public function update(Request $request, $id)
    {
        // Valida os dados recebidos do formulário de edição
        $request->validate([
            'nome_produto' => 'required|string|max:255', // Nome do produto é obrigatório e deve ser uma string
            'quantidade' => 'required|integer|min:0', // A quantidade deve ser um número inteiro e não pode ser negativa
            'preco' => 'required|numeric|min:0', // O preço de custo deve ser numérico e não pode ser negativo
            'preco_venda' => 'required|numeric|min:0', // O preço de venda deve ser numérico e não pode ser negativo
        ]);

        // Encontra o produto pelo ID
        $produto = Produto::findOrFail($id);

        // Atualiza os dados do produto com as novas informações
        $produto->update($request->all());

        // Redireciona para a página de estoque com uma mensagem de sucesso
        return redirect()->route('estoque.index')->with('success', 'Produto atualizado com sucesso!');
    }

    // Excluir um produto
    public function destroy($id)
    {
        // Encontra o produto pelo ID
        $produto = Produto::findOrFail($id);

        // Exclui o produto
        $produto->delete();

        // Redireciona para a página de estoque com uma mensagem de sucesso
        return redirect()->route('estoque.index')->with('success', 'Produto excluído com sucesso!');
    }

    // Atualizar a quantidade de um produto
    public function updateQuantity(Request $request, $id)
    {
        // Encontra o produto pelo ID
        $produto = Produto::findOrFail($id);

        // Verifica se a ação é aumentar ou diminuir a quantidade
        if ($request->action === 'increase') {
            $produto->quantidade += 1; // Aumenta a quantidade em 1
        } elseif ($request->action === 'decrease' && $produto->quantidade > 0) {
            $produto->quantidade -= 1; // Diminui a quantidade em 1 (não permite quantidades negativas)
        }

        // Verifica o estado do produto após a atualização
        if ($produto->quantidade == 0) {
            // Se a quantidade for 0, envia uma mensagem de alerta para a sessão
            session()->flash('alert', 'O produto "' . $produto->nome_produto . '" saiu do estoque!');
        } elseif ($produto->quantidade < 3) {
            // Se a quantidade for menor que 3, envia um alerta de quantidade baixa
            session()->flash('alert', 'Atenção: o produto "' . $produto->nome_produto . '" tem quantidade baixa!');
        }

        // Salva as alterações feitas no produto
        $produto->save();

        // Redireciona para a página de estoque com uma mensagem de sucesso
        return redirect()->route('estoque.index')->with('success', 'Quantidade atualizada com sucesso!');
    }
}
