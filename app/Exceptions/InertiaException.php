<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

abstract class InertiaException extends Exception
{
    protected string $defaultMessage = 'Something went wrong.';

    public function render(Request $request): Response
    {
        return Inertia::render('Error', [
            'message' => $this->getMessage() ?: $this->defaultMessage,
        ])->toResponse($request);
    }
}
