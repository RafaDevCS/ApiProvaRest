<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ServidorTemporarioController;

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::post('/pessoa/novo',[PessoaController::class,'store'])
  ->middleware('auth:sanctum');

Route::get('/servidorTemporario/ver',[ServidorTemporarioController::class,'show'])
  ->middleware('auth:sanctum');

Route::post('/servidor/temporario/novo',[ServidorTemporarioController::class,'store'])
  ->middleware('auth:sanctum');
