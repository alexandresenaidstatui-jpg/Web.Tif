<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionario';

    protected $fillable = [
        'nome',
        'email',
        'registro_funcionario',
        'materias',
        'data_nascimento',
        'senha',
    ];

    protected $hidden = [
        'senha',
    ];
}
