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
            $descricao;
            $confirmacaoRecebida = $request->all();
            $confirmacaoRecebida['problema_id'] = $id;
            
            if (Confirmacao::where($confirmacaoRecebida)->exists()) {
                Confirmacao::where($confirmacaoRecebida)->delete();
                $descricao = 'Voto excluído';                
            } else {
                Confirmacao::updateOrCreate(['problema_id' => $id, 'usuario_id' => $confirmacaoRecebida['usuario_id']], $confirmacaoRecebida);
                $descricao = 'Voto adicionado';
            }

            return $this->createdResponse(['problema' => Problema::showProblema($id), 'descricao' => $descricao]);
        } catch(\Exception $ex) {
            $data = ['exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
   
    }
}
