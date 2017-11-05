<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\RestControllerTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\User as User;

class LoginController extends Controller
{
    use AuthenticatesUsers, RestControllerTrait;

    /**
     * @var object
     */
    private $client;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();
    }

    /**
     * [login description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login(Request $request)
    {
        $request->request->add([
            'username'      => $request->email,
            'password'      => $request->password,
            'grant_type'    => 'password',
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope'         => '*',
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $autenticacao = Route::dispatch($proxy);
        $respostaAuth = json_decode($autenticacao->getContent());

        if (!array_key_exists("error", $respostaAuth)) {
            $user  = User::where('email', '=', $request->email)->first();

            $respostaLogin  = [
                'user_info'      => $user->toArray(),
                'user_auth_info' => $respostaAuth,
            ];

            return $this->listResponse($respostaLogin);
        } else {
            return $this->unauthorizedErrorResponse($respostaAuth);
        }
    }

    protected function invalidateOldTokens($user, $all = false)
    {
        $userTokens = $user->tokens;
        foreach($userTokens as $key => $token) {
            if ($key != 0 || $all) {
                $token->revoke();
            }
        }
    }
}
