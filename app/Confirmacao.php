<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirmacao extends Model
{
    protected $table   = 'confirmacoes';
    public $timestamps = true;
    protected $guarded  = ['id'];
    protected $fillable = [
        'problema_id',
        'usuario_id',
        'tipo_confirmacao'
    ];
    // protected $hidden   = [];
}
