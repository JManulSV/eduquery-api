<?php

namespace App\Http\Middleware;

use App\Models\Classroom;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $resourceIdParam = 'id'): Response
    {
        $resourceId = $request->route($resourceIdParam);
        $user = JWTAuth::parseToken()->authenticate();
        $classroom = Classroom::findOrFail($resourceId);

        if ($classroom->user_id !== $user->id) {
            return response()->json(['status' => 'Unauthorized', 'message' => 'You aren´t the owner of this classroom'], 403);
        }

        return $next($request);
    }
}
