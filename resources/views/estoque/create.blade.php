@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-xl font-bold">Cadastrar Produto</h1>

        <!-- Link para voltar à página de estoque -->
        <a href="{{ route('estoque.index') }}" class="text-blue-500 hover:text-blue-700 mb-4 inline-block">
        &larr; Voltar para o Estoque
        </a>

    <form action="{{ route('estoque.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="form-group">
            <label for="nome_produto" class="block text-gray-700">Nome do Produto</label>
            <input type="text" name="nome_produto" id="nome_produto" class="form-control w-full px-4 py-2 border rounded-md" required>
        </div>
        <div class="form-group">
            <label for="quantidade" class="block text-gray-700">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control w-full px-4 py-2 border rounded-md" required>
        </div>
        <div class="form-group">
            <label for="preco" class="block text-gray-700">Preço</label>
            <input type="number" step="0.01" name="preco" id="preco" class="form-control w-full px-4 py-2 border rounded-md" required>
        </div>
        <div class="form-group">
            <label for="preco_venda" class="block text-gray-700">Preço de Venda</label>
            <input type="number" step="0.01" name="preco_venda" id="preco_venda" class="form-control w-full px-4 py-2 border rounded-md" required>
        </div>
        <button type="submit" class="btn btn-success mt-3 bg-green-500 text-white py-2 px-6 rounded-md">Cadastrar</button>
    </form>
</div>
@endsection
