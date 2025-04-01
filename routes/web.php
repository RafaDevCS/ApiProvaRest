<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::get('/', function () {
    return view('welcome');
});

