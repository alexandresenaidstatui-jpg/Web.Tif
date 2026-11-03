<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')->name('dashboard');
Route::view('/cadastro', 'cadastro')->name('cadastro');
Route::view('/login', 'Login')->name('login');
