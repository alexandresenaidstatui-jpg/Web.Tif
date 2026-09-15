<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mudanca extends Model
{
    protected $table = 'mudancas';

    protected $fillable = [
        'material',
        'justificativa',
    ];
}
