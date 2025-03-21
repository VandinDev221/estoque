<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstoqueController;

Route::get('/', function () {
    return view('resources/views/estoque/index.blade.php');
});

Route::get('/estoque', [EstoqueController::class, 'index'])->name('estoque.index');
Route::get('/estoque/create', [EstoqueController::class, 'create'])->name('estoque.create');
Route::post('/estoque', [EstoqueController::class, 'store'])->name('estoque.store');
Route::get('/estoque/{id}/edit', [EstoqueController::class, 'edit'])->name('estoque.edit');
Route::put('/estoque/{id}', [EstoqueController::class, 'update'])->name('estoque.update');
Route::delete('/estoque/{id}', [EstoqueController::class, 'destroy'])->name('estoque.destroy');
Route::patch('/estoque/{id}/update-quantidade', [EstoqueController::class, 'updateQuantity'])->name('estoque.update-quantidade');
Route::patch('/estoque/{id}/update-quantidade', [EstoqueController::class, 'updateQuantity'])->name('estoque.update-quantity');


