<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\RestControllerTrait;
use App\Confirmacao as Confirmacao;
use App\Problema as Problema;
use App\User as Usuario;
use App\Notifications\ConfirmacaoRecebida;


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

            $problema = Problema::findOrFail($id);

            $confirmador = Auth::user();
            $confirmacaoRecebida = $request->all();

            $confirmacaoRecebida['problema_id'] = $id;
            $confirmacaoRecebida['usuario_id']  = $confirmador->id;

            if (Confirmacao::where($confirmacaoRecebida)->exists()) {
                Confirmacao::where($confirmacaoRecebida)->delete();
            } else {
                Confirmacao::updateOrCreate(['problema_id' => $id, 'usuario_id' => $confirmacaoRecebida['usuario_id']], $confirmacaoRecebida);
            }
            
            $usuarioProblema = Usuario::find($problema->usuario_id);
            $usuarioProblema->notify(new ConfirmacaoRecebida($confirmacaoRecebida));

            return $this->createdResponse($problema->showProblema($id));
        } catch(\Exception $ex) {
            $data = ['exception' => $ex->getTrace()];
            return $this->clientErrorResponse($data);
        }
   
    }
}
