<?php

namespace App\Services\Book;

use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAuthorsForBooks
{
    public function __construct(private ?string $search) {}

    public function execute(): LengthAwarePaginator
    {
        return Author::searchBy($this->search)
            ->paginate(10)
            ->withQueryString();
    }
}
