<?php

namespace App\Services\Book;

use App\Models\Book;

class GetBooksService
{
    public function __construct(private ?string $search) {}

    public function execute()
    {
        return Book::search($this->search)
            ->paginate(10)
            ->withQueryString();
    }
}
