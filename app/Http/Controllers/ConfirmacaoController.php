<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\RestControllerTrait;

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

    public function showAll() {
        return $this->showResponse(Confirmacao::all());
    }
}
