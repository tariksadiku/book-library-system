<?php

namespace App\Exceptions;

class NoBookImageFoundException extends InertiaException
{
    protected string $defaultMessage = 'No image found for this book.';
}
