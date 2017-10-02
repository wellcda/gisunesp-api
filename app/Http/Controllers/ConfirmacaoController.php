<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\RestControllerTrait;
use App\Confirmacao as Confirmacao;

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
            $params = $request->all();
            $params['problema_id'] = $id;
            return $this->createdResponse(Confirmacao::create($params));
        } catch(\Exception $ex) {
            $data = ['exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
   
    }
}
