<?php

namespace App\Services\Author;

use App\Models\Author;

class CreateAuthorService
{
    public function __construct(private string $name, private string $birthDate, private string $biography) {}

    public function execute(): Author
    {
        return Author::create([
            'name' => $this->name,
            'birth_date' => $this->birthDate,
            'biography' => $this->biography,
        ]);
    }
}
