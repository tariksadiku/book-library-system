<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class AddFiltersToProps
{
    public function handle(Request $request, Closure $next): Response
    {
        Inertia::share([
            'filters' => [
                'search' => $request->input('search'),
                'sort' => $request->input('sort'),
                'page' => $request->input('page'),
            ],
        ]);

        return $next($request);
    }
}
