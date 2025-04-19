<?php

namespace App\Services\Author;

use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAuthorsService
{
    public function __construct(private ?string $search, private ?array $sort) {}

    public function execute(): LengthAwarePaginator
    {
        return Author::searchBy($this->search)
            ->sort($this->sort)
            ->paginate(10)
            ->withQueryString();
    }
}
