<?php

namespace App\Exceptions;

class AuthorForBookNotFoundException extends InertiaException
{
    protected string $defaultMessage = 'No author found for this book.';
}
