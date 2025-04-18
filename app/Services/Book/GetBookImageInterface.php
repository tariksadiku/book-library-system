<?php
namespace App\Services\Book;

interface GetBookImageInterface
{
    public function getImageUrl(string $isbn, string $size = 'L'): ?string;
}