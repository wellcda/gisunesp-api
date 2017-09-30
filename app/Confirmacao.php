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

    public function Problema($value='')
    {
    	$this->belongsTo('App\Problema');
    }
    // protected $hidden   = [];
}
