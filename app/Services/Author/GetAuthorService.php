<?php

namespace App\Services\Author;

use App\Models\Author;
use Illuminate\Support\Facades\Cache;

class GetAuthorService
{
    public function __construct(private int $id) {}

    public function execute(): Author
    {
        $author = Author::with('books')->findOrFail($this->id);

        $cacheKey = $author->cacheKey();

        return Cache::remember($cacheKey, 3600, function () use ($author) {
            return $author;
        });
    }
}
