<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::with(['custom_sessions' => function ($query) use ($request) {
            $query->where('token', $request->header('x-token-access'))->first();
        }])->find($request->header('x-user-id'));

        if(!$user) {
            return response()->json(['success' => false, 'message' => 'usuário não encontrado'], 404);
        }

        if($user->custom_sessions->first()->expiration_token >= now()) {
            return $next($request);
        } else {
            return response()->json(['success' => false, 'message' => 'Sessão expirada'], 404);
        }
    }
}
