<?php

namespace App\Exceptions;

use App\Exceptions\InertiaException;

class AuthorForBookNotFoundException extends InertiaException
{
    protected string $defaultMessage = 'No author found for this book.';
}
