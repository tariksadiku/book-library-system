<?php

namespace App\Exceptions;

use App\Exceptions\InertiaException;

class NoBookImageFoundException extends InertiaException
{
    protected string $defaultMessage = 'No image found for this book.';
}
