<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class Problema extends Model
{
    // use PostgisTrait;
    protected $table   = 'problemas';
    public $timestamps = true;
    protected $guarded  = ['id'];
    protected $fillable = [
        'usuario_id',
        'tipo_problema_id',
        'descricao',
        'geom',
        'resolvido'
    ];
    // protected $hidden   = [];
    // protected $postgisFields = [];

    public function tipoProblema() {
        return $this->belongsTo('App\TipoProblema');
    }

}
