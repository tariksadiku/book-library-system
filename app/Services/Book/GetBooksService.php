<?php

namespace App\Services\Book;

use App\Models\Book;

class GetBooksService
{
    public function __construct(private ?string $search, private ?array $sort) {}

    public function execute()
    {
        return Book::with('author')
            ->searchBy($this->search)
            ->sort($this->sort)
            ->paginate(10)
            ->withQueryString();
    }
}
