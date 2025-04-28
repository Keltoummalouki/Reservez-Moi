<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatePostSize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $max = str_replace('M', '', ini_get('post_max_size'));
        $size = $request->server('CONTENT_LENGTH');

        if ($size > $max * 1024 * 1024) {
            return response()->json([
                'message' => 'La taille du fichier dépasse la limite autorisée (' . $max . 'MB)',
                'errors' => ['file' => ['Le fichier est trop volumineux']]
            ], Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
        }

        return $next($request);
    }
} 