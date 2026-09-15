<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MudancaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioCadastro;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

route::post('/cadastro_usuario', [UsuarioCadastro::class, 'cadastro_usuario']);
Route::post('/login', [LoginController::class, 'login_api']);
Route::post('/mudancas', [MudancaController::class, 'criar']);
