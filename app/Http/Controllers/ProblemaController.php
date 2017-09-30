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
        $problema = Problema::find($id);
        $problema->votos_pos = Confirmacao::where('problema_id', $id)->where('tipo_confirmacao', 0)->count();
        $problema->votos_neg = Confirmacao::where('problema_id', $id)->where('tipo_confirmacao', 1)->count();
        return $this->showResponse($problema);
    }

    public function showAll() {
        return $this->showResponse(Problema::showAllWithLatLon());
    }

    public function storeFromLatLon(Request $request) {
        return $this->showResponse(Problema::storeWithLatLon($request->all()));
    }

}
