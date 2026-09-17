<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\loginFuncionario;
use App\Http\Controllers\FuncionarioCadastro;
use App\Http\Controllers\MudancaController;
use App\Http\Controllers\UsuarioCadastro;

Route::get('/', function () {
    return view('boas_vindas');
})->name('welcome');

Route::get('/cadastro_usuario', [UsuarioCadastro::class, 'cadastro_usuario_html'])
    ->name('cadastro.usuario');

Route::get('/cadastro-funcionario', [FuncionarioCadastro::class, 'cadastro_html'])
    ->name('cadastro.funcionario');

Route::get('/login', [LoginController::class, 'login_html'])
    ->name('login');

Route::get('/login-funcionario', [loginFuncionario::class, 'login_html'])
    ->name('login.funcionario');

Route::get('/mudanca', function () {
    return view('mudanca');
})->name('mudanca');

Route::get('/mudancas-realizadas', [MudancaController::class, 'listar'])
    ->name('mudancas.realizadas');

Route::get('/mudancas/{mudanca}/editar', [MudancaController::class, 'editar'])
    ->name('mudancas.editar');
Route::put('/mudancas/{mudanca}', [MudancaController::class, 'atualizar'])
    ->name('mudancas.atualizar');
Route::delete('/mudancas/{mudanca}', [MudancaController::class, 'excluir'])
    ->name('mudancas.excluir');
