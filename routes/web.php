<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstoqueController;

// Página inicial que exibe o estoque
Route::get('/', function () {
    return view('estoque.index');
});

// Rotas para o controlador de estoque
Route::get('/estoque', [EstoqueController::class, 'index'])->name('estoque.index');
Route::get('/estoque/create', [EstoqueController::class, 'create'])->name('estoque.create');
Route::post('/estoque', [EstoqueController::class, 'store'])->name('estoque.store');
Route::get('/estoque/{id}/edit', [EstoqueController::class, 'edit'])->name('estoque.edit');
Route::put('/estoque/{id}', [EstoqueController::class, 'update'])->name('estoque.update');
Route::delete('/estoque/{id}', [EstoqueController::class, 'destroy'])->name('estoque.destroy');

// Atualização da quantidade, mantendo apenas uma rota
Route::patch('/estoque/{id}/update-quantidade', [EstoqueController::class, 'updateQuantity'])->name('estoque.update-quantidade');
