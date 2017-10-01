<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirmacao extends Model
{
    protected $table   = 'confirmacoes';
    public $timestamps = false;
    protected $guarded  = ['id'];
    protected $fillable = [
        'problema_id',
        'usuario_id',
        'tipo_confirmacao'
    ];

    public function problema()
    {
    	$this->belongsTo('App\Problema');
    }
    // protected $hidden   = [];
}
