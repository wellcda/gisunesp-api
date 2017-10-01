<?php

namespace App\Http\Controllers;

use App\Http\Traits\RestControllerTrait;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TipoProblema as TipoProblema;

class TipoProblemaController extends Controller
{

    const MODEL = 'App\TipoProblema';
    use RestControllerTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
}
