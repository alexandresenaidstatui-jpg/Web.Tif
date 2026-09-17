<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenFuncionario extends Model
{
    protected $table = 'token_funcionario';

    protected $fillable = [
        'funcionario_id',
        'token',
        'valido_ate',
    ];
}
