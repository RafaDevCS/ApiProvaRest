<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UnidadeEnderecoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\LotacaoController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\ServidorEfetivoController;


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/renovarToken', [AuthController::class, 'renovarToken']);
Route::post('/auth/verTokens', [AuthController::class, 'verTokens']);

Route::post('/pessoa/novo',[PessoaController::class,'store'])
  ->middleware('auth:sanctum');
Route::get('/pessoa/{id}',[PessoaController::class,'show'])
  ->middleware('auth:sanctum');
Route::get('/pessoa/',[PessoaController::class,'index'])
  ->middleware('auth:sanctum');
Route::put('/pessoa/atualiza/{id}',[PessoaController::class,'update'])
  ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
  Route::post('/unidade/novo',[UnidadeController::class,'store'])->name('cria');
  Route::get('/unidade/{id}',[UnidadeController::class,'show'])->name('busca');
  Route::get('/unidade/',[UnidadeController::class,'index'])->name('todos');
  Route::put('/unidade/atualiza/{id}',[UnidadeController::class,'update'])->name('altera');

  Route::post('/unidadeEnd/novo',[UnidadeEnderecoController::class,'store'])->name('cria');
  Route::get('/unidadeEnd/{id}',[UnidadeEnderecoController::class,'show'])->name('busca');
  Route::get('/unidadeEnd/',[UnidadeEnderecoController::class,'index'])->name('todos');
  Route::put('/unidadeEnd/atualiza/{id}',[UnidadeEnderecoController::class,'update'])->name('altera');
  Route::get('/unidadeEnd/deleta/{id}',[UnidadeEnderecoController::class,'deleta'])->name('apaga');

  Route::post('/lotacao/novo',[LotacaoController::class,'store'])->name('cria');
  Route::get('/lotacao/{id}',[LotacaoController::class,'show'])->name('busca');
  Route::get('/lotacao/deleta/{id}',[LotacaoController::class,'deleta'])->name('apaga');
  Route::get('/lotacao/',[LotacaoController::class,'index'])->name('todos');
  Route::put('/lotacao/atualiza/{id}',[LotacaoController::class,'update'])->name('altera');
  Route::post('/servidorEfetivo/novo',[ServidorEfetivoController::class,'store'])->name('cria');
  Route::get('/servidorEfetivo/{id}',[ServidorEfetivoController::class,'show'])->name('busca');
  Route::get('/servidorEfetivo/deleta/{id}',[ServidorEfetivoController::class,'deleta'])->name('apaga');
  Route::get('/servidorEfetivo/',[ServidorEfetivoController::class,'index'])->name('todos');
  Route::put('/lotacao/atualiza/{id}',[ServidorEfetivoController::class,'update'])->name('altera');
  Route::post('/cidade/novo',[CidadeController::class,'store'])->name('cria');
  Route::get('/cidade/{id}',[CidadeController::class,'show'])->name('busca');
  Route::get('/cidade/',[CidadeController::class,'index'])->name('todos');
  Route::put('/cidade/atualiza/{id}',[CidadeController::class,'update'])->name('altera');
  Route::post('/endereco/novo',[EnderecoController::class,'store'])->name('cria');
  Route::get('/endereco/{id}',[EnderecoController::class,'show'])->name('busca');
  Route::get('/endereco/',[EnderecoController::class,'index'])->name('todos');
  Route::put('/endereco/atualiza/{id}',[EnderecoController::class,'update'])->name('altera');
  Route::post('/fotoPessoa/novo',[FotoPessoaController::class,'store'])->name('cria');
  Route::get('/fotoPessoa/{id}',[FotoPessoaController::class,'show'])->name('busca');
  Route::get('/fotoPessoa/',[FotoPessoaController::class,'index'])->name('todos');
  Route::put('/fotoPessoa/atualiza/{id}',[FotoPessoaController::class,'update'])->name('altera');
  Route::post('/servidorT/novo',[ServidorTemporarioController::class,'store'])->name('cria');
  Route::get('/servidorT/{id}',[ServidorTemporarioController::class,'show'])->name('busca');
  Route::get('/servidorT/',[ServidorTemporarioController::class,'index'])->name('todos');
  Route::put('/servidorT/atualiza/{id}',[ServidorTemporarioController::class,'update'])->name('altera');
});



/*
Route::prefix('auth')->group(function () {
  Route::post('login', [AuthController::class, 'login'])->name('login');
  Route::post('register', [AuthController::class, 'register'])->name('register');
  Route::post('logout', [AuthController::class, 'logout'])->name('logout');

  Route::middleware('auth:sanctum')->group(function () {
      Route::post('refresh-token', [AuthController::class, 'refresh'])
          ->name('refresh');
  });
});

*/