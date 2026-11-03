<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lixeira extends Model
{
    protected $table = 'lixeiras';

    protected $primaryKey = 'tipo';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'tipo',
        'nome',
        'cor',
        'aberta',
        'atualizada_por',
    ];

    protected function casts(): array
    {
        return [
            'aberta' => 'boolean',
        ];
    }

    public function atualizadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'atualizada_por');
    }
}
