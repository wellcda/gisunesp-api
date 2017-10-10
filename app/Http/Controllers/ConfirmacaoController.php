<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\RestControllerTrait;
use App\Confirmacao as Confirmacao;
use App\Problema as Problema;

class ConfirmacaoController extends Controller
{
    const MODEL = 'App\Confirmacao';
    use RestControllerTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function storeConfirmacao($id, Request $request) 
    {
        
        try {
            $confirmacao = $request->all();
            $confirmacao['problema_id'] = $id;
            $novaConfirmacao = Confirmacao::updateOrCreate(['problema_id' => $id, 'usuario_id' => $confirmacao['usuario_id']], $confirmacao);
            return $this->createdResponse(Problema::showProblema($id));
        } catch(\Exception $ex) {
            $data = ['exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
   
    }
}
