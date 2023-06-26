<?php

namespace App\Http\Middleware;

use App\Models\Outlet;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-Api-Key');
        $outlet = Outlet::where('key', $apiKey)->first();
        if (!$outlet) {
            return response()->json(['success' => false], 401);
        }
        $request->attributes->add(['outlet_id' => $outlet->id]);
        return $next($request);
    }
}