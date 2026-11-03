<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LixeiraController;
use App\Http\Controllers\UsuarioCadastro;

Route::post('/cadastro_usuario', [UsuarioCadastro::class, 'cadastro_usuario']);
Route::post('/login', [LoginController::class, 'login_api']);

Route::middleware('logado')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/lixeiras', [LixeiraController::class, 'listar']);
    Route::patch('/lixeiras/{tipo}', [LixeiraController::class, 'atualizar']);
});
