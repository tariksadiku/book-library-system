<?php

namespace App\Services\Book;

use App\Models\Book;
use App\Traits\HasCacheKey;
use Illuminate\Support\Facades\Cache;

class GetBookService
{
    use HasCacheKey;

    public function __construct(private int $id) {}

    public function execute(): Book
    {
        $book = Book::with('author')->findOrFail($this->id);

        $cacheKey = $book->cacheKey();

        return Cache::remember($cacheKey, 3600, function () use ($book) {
            return $book;
        });
    }
}
