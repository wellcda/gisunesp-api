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
        'resolvido'
    ];
    protected $hidden   = ['geom'];
    protected $postgisFields = ['geom'];

    public function tipoProblema() {
        return $this->belongsTo('App\TipoProblema');
    }

    public function confirmacao()
    {
        return $this->hasMany('App\Confirmacao');
    }

    public function confirmacoesPositivas() {
        return $this->hasMany('App\Confirmacao')::where('tipo_confirmacao', '0');
    }

    public function confirmacoesNegativas() {
        return $this->hasMany('App\Confirmacao')::where('tipo_confirmacao', '1');
    }

    public static function storeWithLatLon($params) {
        $problema =  (Object) [
            'usuario'   => $params['usuario_id'],
            'tipo'      => $params['tipo_problema_id'],
            'descricao' => $params['descricao'],
            'resolvido' => 'false',
            'x'         => $params['lon'],
            'y'         => $params['lat']
        ];

        return DB::insert("INSERT INTO problemas(usuario_id, tipo_problema_id, descricao, resolvido, created_at, updated_at, geom)
            values ($problema->usuario, $problema->tipo, '$problema->descricao', $problema->resolvido, now(), now(), ST_MakePoint($problema->x, $problema->y));");
    }

    public static function showAllWithLatLon() {
        return DB::select("SELECT descricao, ST_X(geom::geometry) as lon, ST_Y(geom::geometry) as lat FROM problemas WHERE geom is not null");
    }

}
