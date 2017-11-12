<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

            if ($request->input('tipo_confirmacao') < 1 || $request->input('tipo_confirmacao') > 2)
                return $this->acceptedResponse('Tipo de confirmação inexistente');

            $problema = Problema::findOrFail($id);
            $confirmador = $request->user();
            $confirmacaoRecebida = $request->all();

            $confirmacaoRecebida['problema_id'] = $id;
            $confirmacaoRecebida['usuario_id']  = $confirmador->id;

            if (Confirmacao::where($confirmacaoRecebida)->exists()) {
                Confirmacao::where($confirmacaoRecebida)->delete();
            } else {
                $confirmacao = Confirmacao::updateOrCreate(['problema_id' => $id, 'usuario_id' => $confirmacaoRecebida['usuario_id']], $confirmacaoRecebida);
                
                $idUsuariosInteressados = Confirmacao::select('usuario_id')->where('problema_id', $id)->get()->map(function ($usuario) {
                    return $usuario->id;
                });
                
                $usuarioProblema = Usuario::find($problema->usuario_id);
                $usuariosInteressados = Usuario::whereIn('id', $idUsuariosInteressados)->get();
                $usuariosInteressados->merge([$usuarioProblema]);

                \Notification::send($usuariosInteressados, new ConfirmacaoRecebida($confirmacao));
            }
            

            return $this->createdResponse($problema->getFromDB($id));
        } catch(\Exception $ex) {
            $data = ['exception' => $ex->getTrace()];
            return $this->clientErrorResponse($data);
        }
   
    }
}
