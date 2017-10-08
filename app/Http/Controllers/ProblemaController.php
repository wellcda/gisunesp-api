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
    const CONFIRMACOES_POSITIVAS = 1;
    const CONFIRMACOES_NEGATIVAS = 2;

    use RestControllerTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function showProblema($problemaId)
    {   
        return $this->showResponse(Problema::showProblema($problemaId));
    }

    public function showProblemas(Request $request) 
    {
        return $this->showResponse(Problema::showProblema(false, false, $request->all()));
    }

    public function showProblemasPorUsuario($usuarioId) 
    {
        return $this->showResponse(Problema::showProblema(false, $usuarioId));
    }

    public function storeProblema(Request $request) 
    {
        try {
            return $this->createdResponse(Problema::storeProblema($request->all()));
        } catch (\Exception $ex) {
            $data = ['exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
        
    }

}
