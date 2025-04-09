<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UnidadeEnderecoController;
use App\Http\Controllers\PessoaEnderecoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\LotacaoController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\ServidorEfetivoController;


Route::post('/auth/registra', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
  
  Route::post('/auth/renovarToken', [AuthController::class, 'renovarToken'])->name('renovar');
  Route::post('/auth/renovarToken/{id}', [AuthController::class, 'renovarTokenId'])->name('renovarId');
});


Route::middleware(['auth:sanctum', 'abilities:acesso'])->group(function () {
  Route::post('/unidade/novo',[UnidadeEnderecoController::class,'store'])->name('criaUnidade');
  Route::get('/unidade/{id}',[UnidadeEnderecoController::class,'show'])->name('buscaUnidade');
  Route::get('/unidade/',[UnidadeEnderecoController::class,'index'])->name('todosUnidade');
  Route::put('/unidade/atualiza/{id}',[UnidadeEnderecoController::class,'update'])->name('alteraUnidade');
  Route::get('/unidade/deleta/{id}',[UnidadeEnderecoController::class,'deleta'])->name('apagaUnidade');

  
  Route::post('/fotoPessoa/novo',[FotoPessoaEnderecoController::class,'store'])->name('cria');
  Route::get('/fotoPessoa/{id}',[FotoPessoaEnderecoController::class,'show'])->name('busca');
  Route::get('/fotoPessoa/',[FotoPessoaEnderecoController::class,'index'])->name('todos');
  Route::put('/fotoPessoa/atualiza/{id}',[FotoPessoaEnderecoController::class,'update'])->name('altera');
  Route::get('/fotoPessoa/deleta/{id}',[FotoPessoaEnderecoController::class,'deleta'])->name('apaga');

  Route::post('/lotacao/novo',[LotacaoController::class,'store'])->name('cria');
  Route::get('/lotacao/{id}',[LotacaoController::class,'show'])->name('busca');
  Route::get('/lotacao/deleta/{id}',[LotacaoController::class,'deleta'])->name('apaga');
  Route::get('/lotacao/',[LotacaoController::class,'index'])->name('todos');
  Route::put('/lotacao/atualiza/{id}',[LotacaoController::class,'update'])->name('altera');
  
  Route::post('/servidorEfetivo/novo',[ServidorEfetivoController::class,'store'])->name('cria');
  Route::get('/servidorEfetivo/{id}',[ServidorEfetivoController::class,'show'])->name('busca');
  Route::get('/servidorEfetivo/buscarPorUnidade/{id}',[ServidorEfetivoController::class,'buscarPorUnidade'])->name('buscaUnidade');
  Route::get('/servidorEfetivo/enderecoFuncional/{id}',[ServidorEfetivoController::class,'enderecoFuncional'])->name('enderecoFunc');
  Route::get('/servidorEfetivo/deleta/{id}',[ServidorEfetivoController::class,'deleta'])->name('apaga');
  Route::get('/servidorEfetivo/',[ServidorEfetivoController::class,'index'])->name('todos');
  Route::put('/servidorEfetivo/atualiza/{id}',[ServidorEfetivoController::class,'update'])->name('altera');
  
  Route::post('/servidorTemporario/novo',[ServidorTemporarioController::class,'store'])->name('cria');
  Route::get('/servidorTemporario/{id}',[ServidorTemporarioController::class,'show'])->name('busca');
  Route::get('/servidorTemporario/',[ServidorTemporarioController::class,'index'])->name('todos');
  Route::put('/servidorTemporario/atualiza/{id}',[ServidorTemporarioController::class,'update'])->name('altera');
});
