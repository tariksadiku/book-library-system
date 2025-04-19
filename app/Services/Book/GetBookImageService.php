<?php

namespace App\Services\Book;

use App\Contracts\GetBookImageInterface;
use Illuminate\Support\Facades\Http;

class GetBookImageService implements GetBookImageInterface
{
    private string $bookApiUrl = 'https://openlibrary.org/isbn/';

    private string $coverBaseUrl = 'https://covers.openlibrary.org/b/id/';

    public function getImageUrl(string $isbn, string $size = 'S'): ?string
    {
        $isbn = trim($isbn);

        if (empty($isbn)) {
            return null;
        }

        $response = Http::get($this->bookApiUrl.$isbn.'.json');

        if (! $response->ok() || ! $response->json('covers')) {
            return null;
        }

        $coverId = $response->json('covers')[0] ?? null;

        if (! $coverId) {
            return null;
        }

        return $this->coverBaseUrl.$coverId.'-'.$size.'.jpg';
    }
}
