<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\RestControllerTrait;
use App\User as User;

class UserController extends Controller
{
  	const MODEL = 'App\User';

    use RestControllerTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

     public function store(Request $request)
    {
        $this->validate($request, [
        	'password' => 'required',
        	'email'    => 'required|unique:users'
    	]);

        $user = User::create($request->all());

        return $this->createdResponse($user);
    }

    public function getNotificacoesNaoLidas(Request $request) {
        $user = $request->user();
        $user->unreadNotifications;
        dd($user->notifications);
        return $this->listResponse($user->unreadNotifications);
    }


}
