<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\ServidorTemporarioController;

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
  Route::post('/cidade/novo',[CidadeController::class,'store'])->name('cria');
  Route::get('/cidade/{id}',[CidadeController::class,'show'])->name('busca');
  Route::get('/cidade/',[CidadeController::class,'index'])->name('todos');
  Route::put('/cidade/atualiza/{id}',[CidadeController::class,'update'])->name('altera');
  Route::post('/endereco/novo',[EnderecoController::class,'store'])->name('cria');
  Route::get('/endereco/{id}',[EnderecoController::class,'show'])->name('busca');
  Route::get('/endereco/',[EnderecoController::class,'index'])->name('todos');
  Route::put('/endereco/atualiza/{id}',[EnderecoController::class,'update'])->name('altera');
});

Route::get('/servidorTemporario/ver',[ServidorTemporarioController::class,'show'])
  ->middleware('auth:sanctum');

Route::post('/servidor/temporario/novo',[ServidorTemporarioController::class,'store'])
  ->middleware('auth:sanctum');


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