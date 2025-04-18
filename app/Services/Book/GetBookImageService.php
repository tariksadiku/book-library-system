<?php

namespace App\Services\Book;

use Illuminate\Support\Facades\Http;

class GetBookImageService implements GetBookImageInterface
{
    private string $baseUrl = 'https://covers.openlibrary.org/b/isbn/';

    public function getImageUrl(string $isbn, string $size = 'L'): ?string
    {
        $isbn = trim($isbn);

        if (empty($isbn)) {
            return null;
        }

        $url = $this->baseUrl.$isbn.'-'.$size.'.jpg';

        $response = Http::head($url);

        return $response->ok() ? $url : null;
    }
}
