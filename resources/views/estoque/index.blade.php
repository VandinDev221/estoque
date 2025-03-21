@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-2xl font-bold text-gray-900">Produtos em Estoque</h1>

        <!-- Exibição de Mensagens de Alerta -->
        @if(session('alert'))
            <div class="bg-yellow-300 text-yellow-800 p-4 rounded-lg mb-4">
                <p>{{ session('alert') }}</p>
            </div>
        @endif

        <!-- Formulário de Busca e Botão para Adicionar Produto -->
        <div class="mb-4 flex justify-between items-center space-x-2">
            <form action="{{ route('estoque.index') }}" method="GET" class="flex space-x-2 flex-1">
                <input type="text" name="search" placeholder="Buscar por nome do produto"
                       class="px-4 py-2 border border-gray-300 rounded-md w-full md:w-1/3"
                       value="{{ request('search') }}">
                <button type="submit" class="bg-blue-600 text-white hover:bg-blue-500 px-4 py-2 rounded-md">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>

            <a href="{{ route('estoque.create') }}" class="btn bg-blue-600 text-white hover:bg-blue-500 px-4 py-2 rounded-md">
                <i class="fas fa-plus"></i> Adicionar Produto
            </a>
        </div>

        <!-- Exibir o total de produtos e total de quantidade -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Total de Produtos Cadastrados -->
            <div class="bg-blue-100 p-4 rounded-lg shadow-md text-center">
                <p class="text-lg font-semibold text-blue-600">Total de produtos cadastrados:</p>
                <p class="text-2xl font-bold text-gray-900">{{ $produtos->count() }}</p>
            </div>

            <!-- Total de Itens em Estoque -->
            <div class="bg-green-100 p-4 rounded-lg shadow-md text-center">
                <p class="text-lg font-semibold text-green-600">Total de itens em estoque:</p>
                <p class="text-2xl font-bold text-gray-900">{{ $produtos->sum('quantidade') }}</p>
            </div>
        </div>

        <!-- Tabela de Produtos -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-gray-800" id="produtosTable">
                <thead>
                    <tr class="bg-gray-700 text-white">
                        <th class="px-4 py-2 text-left">Nome</th>
                        <th class="px-4 py-2 text-left">Quantidade</th>
                        <th class="px-4 py-2 text-left">Preço</th>
                        <th class="px-4 py-2 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr id="produto-{{ $produto->id }}" class="@if($produto->quantidade < 3) bg-yellow-300 @endif">
                            <td class="px-4 py-2 border-b border-gray-300">{{ $produto->nome_produto }}</td>

                            <!-- Formulários de Aumentar e Diminuir Quantidade -->
                            <td class="px-4 py-2 border-b border-gray-300 flex items-center space-x-2">
                                <!-- Decrementar Quantidade -->
                                <form action="{{ route('estoque.update-quantity', $produto->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="text-red-400 hover:text-red-500 text-lg font-semibold">-</button>
                                </form>

                                <!-- Quantidade Atual -->
                                <span>{{ $produto->quantidade }}</span>

                                <!-- Incrementar Quantidade -->
                                <form action="{{ route('estoque.update-quantity', $produto->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="increase">
                                    <button type="submit" class="text-green-400 hover:text-green-500 text-lg font-semibold">+</button>
                                </form>
                            </td>

                            <td class="px-4 py-2 border-b border-gray-300">
                                {{ number_format($produto->preco_venda, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 border-b border-gray-300 flex space-x-2">
                                <a href="{{ route('estoque.edit', $produto->id) }}" class="btn bg-gray-600 text-white hover:bg-gray-500 px-4 py-2 rounded-md">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('estoque.destroy', $produto->id) }}" method="POST" class="deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn bg-red-600 text-white hover:bg-red-500 px-4 py-2 rounded-md">
                                        <i class="fas fa-trash-alt"></i> Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
