<?php

namespace App\Contracts;

interface GetBookImageInterface
{
    public function getImageUrl(string $isbn, string $size = 'L'): ?string;
}
