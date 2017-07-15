<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table   = 'notificacoes';
    public $timestamps = true;
    protected $guarded  = ['id'];
    protected $fillable = [
        'problema_id',
        'usuario_id',
        'tipo_notificacao_id',
        'visualizado'
    ]
    // protected $hidden   = [];
    // protected $postgisFields = [];

}
