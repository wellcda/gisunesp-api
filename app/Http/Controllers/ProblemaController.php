<?php

namespace App\Http\Controllers;

use App\Http\Traits\RestControllerTrait;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Problema as Problema;
use App\Confirmacao as Confirmacao;
use App\User as User;
use App\Notifications\ProblemaResolvido;

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
        return $this->showResponse(Problema::getFromDB($problemaId));
    }

    public function showProblemas(Request $request) 
    {
        return $this->showResponse(Problema::getFromDB(false, false, $request->all()));
    }

    public function showProblemasPorUsuario($usuarioId) 
    {
        return $this->showResponse(Problema::getFromDB(false, $usuarioId));
    }

    public function storeProblema(Request $request) 
    {
        try {
            return $this->createdResponse(Problema::storeProblema($request->all()));
        } catch (\Exception $ex) {
            return $this->clientErrorResponse($data);
        }
        
    }

    public function resolveProblema($id)
    {
        try {
            $problema = Problema::findOrFail($id);
            $problema->resolvido = !$problema->resolvido;
            $problema->save();

            User::find($problema->usuario_id)->notify(new ProblemaResolvido());

            return $this->listResponse($problema);
        } catch (\Exception $ex) {
            return $this->notFoundResponse();
        }
    }

}
