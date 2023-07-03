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
        $outlet->last_breath = date("Y-m-d H:i:s", time());
        $outlet->touch();
        $outlet->save();
        $request->attributes->add(['outlet' => $outlet->id]);
        return $next($request);
    }
}