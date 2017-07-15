<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use DB;


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
    protected $hidden   = ['geom'];
    protected $postgisFields = ['geom'];

    public function tipoProblema() {
        return $this->belongsTo('App\TipoProblema');
    }

    public function saveWithLatLon($params) {
        // DB::table('problemas')->select()
    }

}
