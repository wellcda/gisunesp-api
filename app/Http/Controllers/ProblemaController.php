<?php

namespace App\Http\Controllers;

use App\Http\Traits\RestControllerTrait;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Problema as Problema;

class ProblemaController extends Controller
{

    const MODEL = 'App\Problema';
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
        $problemas = Problema::all();
        return $this->showResponse($problemas);
    }

}
