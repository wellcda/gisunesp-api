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

    public function showProblema($id)
    {   
        return $this->showResponse(Problema::showProblema($id));
    }

    public function showProblemas() {
        return $this->showResponse(Problema::showProblema());
    }

    public function storeProblema(Request $request) {
        return $this->showResponse(Problema::storeProblema($request->all()));
    }

}
