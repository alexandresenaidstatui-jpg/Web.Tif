<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mudanca extends Model
{
    protected $table = 'mudancas';

    protected $fillable = [
        'responsavel_tipo',
        'origem',
        'destino',
        'material',
        'justificativa',
    ];
}
