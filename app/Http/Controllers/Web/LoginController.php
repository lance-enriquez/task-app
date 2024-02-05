<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\LoginService;

/**
 *
 *
 *
 */
class LoginController
{
    /**
     *
     *
     * @var LoginService
     */
    protected LoginService $loginService;

    /**
     *
     *
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request): mixed
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $response = $this->loginService->login($username, $password);
        $status = Arr::get($response, 'status', false);
        $path = $status ? '/home' : '/';

        if ($status) {
            session([
                'user_id'   => Arr::get($response, 'data.user_id'),
                'api_token' => Arr::get($response, 'data.api_token')
            ]);
        }

        return redirect($path);
    }
}
