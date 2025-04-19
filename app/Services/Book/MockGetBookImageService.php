<?php

namespace App\Services\Book;

use App\Contracts\GetBookImageInterface;

class MockGetBookImageService implements GetBookImageInterface
{
    public function getImageUrl(string $isbn, string $size = 'L'): ?string
    {
        return "https://covers.openlibrary.org/b/id/1234567-L.jpg";
    }
}
