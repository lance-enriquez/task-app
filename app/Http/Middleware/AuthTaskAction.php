<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class AuthTaskAction
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isQueryParam = ($request->getMethod() === 'GET');
        $userId = ($isQueryParam) ? $request->get('user_id') : $request->json('user_id');
        $apiToken = ($isQueryParam) ? $request->get('api_token') : $request->json('api_token');
        $status = $this->user->validateApiToken($userId, $apiToken);
        return ($status) ? $next($request) : response(null, 403);
    }
}
