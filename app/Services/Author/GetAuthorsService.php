<?php

namespace App\Services\Author;

use App\Models\Author;

class GetAuthorsService
{
    public function __construct(private ?string $search){}

    public function execute()
    {
        return Author::search($this->search)
            ->paginate(10)
            ->withQueryString();
    }
}