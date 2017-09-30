<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProblema extends Model
{
    protected $table   = 'tipos_problema';
    public $timestamps = true;
    protected $guarded  = ['id'];
    protected $fillable = [
        'descricao',
        'tipo_geom'
    ];
    // protected $hidden   = [];

    public function problemas()
    {
        return $this->hasMany('App\Problema');
    }
}
