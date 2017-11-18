<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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
                
                $idUsuariosInteressados = Confirmacao::select('usuario_id')->where('problema_id', $id)->pluck('usuario_id');
                $notificacao = new ConfirmacaoRecebida($confirmacao);
                
                $usuarioProblema = Usuario::find($problema->usuario_id);
                $usuarioProblema->notify($notificacao);
                
                $usuariosInteressados = Usuario::whereIn('id', $idUsuariosInteressados)->get();
                $usuariosInteressados->merge([$usuarioProblema]);
                 
                Notification::send($usuariosInteressados, new ConfirmacaoRecebida($confirmacao));                
            }
            

            return $this->createdResponse($problema->getFromDB($id));
        } catch(\Exception $ex) {
            $data = ['exception' => $ex->getTrace()];
            return $this->clientErrorResponse($data);
        }
   
    }
}
