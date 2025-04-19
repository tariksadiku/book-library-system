<?php

namespace App\Services\Book;

use App\Models\Book;

class GetBooksService
{
    public function __construct(private ?string $search, private ?string $sort) {}

    public function execute()
    {
        return Book::with('author')
            ->search($this->search)
            ->sort($this->sort)
            ->paginate(10)
            ->withQueryString();
    }
}
