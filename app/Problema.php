<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait as PostgisTrait;
use DB;


class Problema extends Model
{
    const CONFIRMACOES_POSITIVAS = 1;
    const CONFIRMACOES_NEGATIVAS = 2;
    
    protected $table   = 'problemas';
    public $timestamps = true;
    protected $guarded  = ['id'];
    protected $fillable = [
        'titulo',
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

    public static function storeProblema($params) 
    {
        $problema =  (Object) [
            'titulo'    => $params['titulo'],
            'usuario'   => $params['usuario_id'],
            'tipo'      => $params['tipo_problema_id'],
            'descricao' => $params['descricao'],
            'resolvido' => 'false',
            'x'         => $params['lon'],
            'y'         => $params['lat']
        ];
        return DB::insert("INSERT INTO problemas(titulo, usuario_id, tipo_problema_id, descricao, resolvido, created_at, updated_at, geom)
            values ('$problema->titulo', $problema->usuario, $problema->tipo, '$problema->descricao', $problema->resolvido, now(), now(), ST_MakePoint($problema->x, $problema->y));");
    }

    public static function getFromDB($problemaId = false, $usuarioId = false, $orderParams = []) 
    {
        $filtrarProblema = $problemaId? " AND p.id = $problemaId " : "";
        $filtarUsuario   = $usuarioId? " AND p.usuario_id = $usuarioId " : "";
        $confirmacoes_positivas = self::CONFIRMACOES_POSITIVAS;
        $confirmacoes_negativas = self::CONFIRMACOES_NEGATIVAS;
        $orderBy = '';

        if (isset($orderParams['order_antigos'])) {
            $orderBy = 'ORDER BY p.created_at ASC ';
        }

        if (isset($orderParams['order_votos_pos'])) {
            $orderBy = 'ORDER BY votos_pos DESC ';
        }

        if (isset($orderParams['order_votos_neg'])) {
            $orderBy = 'ORDER BY votos_neg DESC ';
        }

        return DB::select("SELECT 
                        p.id as problema_id, 
                        p.titulo,
                        p.usuario_id, 
                        p.descricao,
                        ST_X(geom::geometry) as lon, 
                        ST_Y(geom::geometry) as lat,
                        count(CASE WHEN tipo_confirmacao = $confirmacoes_positivas THEN 1 ELSE NULL END) as votos_pos,
                        count(CASE WHEN tipo_confirmacao = $confirmacoes_negativas THEN 1 ELSE NULL END) as votos_neg
                    FROM problemas p
                    LEFT JOIN confirmacoes c on c.problema_id = p.id
                    WHERE geom is not null
                    $filtrarProblema
                    $filtarUsuario
                    GROUP by p.id, p.descricao
                    $orderBy
                ");
    }

}
