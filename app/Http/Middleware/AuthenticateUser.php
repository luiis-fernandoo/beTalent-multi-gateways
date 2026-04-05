<?php

namespace App\Http\Middleware;

use App\Http\Console\Constants\UserConstants;
use App\Models\RouteAccess;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find($request->header('x-user-id'));

        if($user->role_id == UserConstants::ADMIN)
        {
            return $next($request);
        }

        $route = explode('/', $request->url());
        $access = RouteAccess::where('role_id', $user->role_id)
            ->where('route', end($route))
            ->where('http_method', $request->method())
            ->first();

        if (collect($access)->isEmpty()) {
            return response()->json([
                'message' => 'Acesso negado. Usuário não tem permissão para esta ação.'
            ], 403);
        }

        return $next($request);
    }
}
