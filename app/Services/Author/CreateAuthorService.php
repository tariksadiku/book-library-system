<?php

namespace App\Services\Author;

use App\Models\Author;

class CreateAuthorService
{
    public function __construct(private string $name) {}

    public function execute(): Author
    {
        return Author::create([
            'name' => $this->name,
        ]);
    }
}
