<?php

namespace App\Http\Controllers;

use App\Http\Traits\RestControllerTrait;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Problema as Problema;
use App\Confirmacao as Confirmacao;

class ProblemaController extends Controller
{

    const MODEL = 'App\Problema';
    const CONFIRMACOES_POSITIVAS = 0;
    const CONFIRMACOES_NEGATIVAS = 1;

    use RestControllerTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function showComConfirmacao($id)
    {   
        $problema            = Problema::with('confirmacao')->find($id);
        $confirmacoes        = $problema->confirmacao->groupBy('tipo_confirmacao');
        $problema->votos_pos = $confirmacoes[self::CONFIRMACOES_POSITIVAS]->count();
        $problema->votos_neg = $confirmacoes[self::CONFIRMACOES_NEGATIVAS]->count();

        unset($problema->confirmacao);

        return $this->showResponse($problema);
    }

    public function showAll() {
        return $this->showResponse(Problema::showAllWithLatLon());
    }

    public function storeFromLatLon(Request $request) {
        return $this->showResponse(Problema::storeWithLatLon($request->all()));
    }

}
