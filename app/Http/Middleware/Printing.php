<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Session;

class Printing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session_id = $request->route("id");
        $id = Session::where(["session" => $session_id])->first();
        if (!$id)
            return response()->json(["success" => false, "msg" => "Not found"], 404);
        return $next($request);

    }
}