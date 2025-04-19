<?php

namespace App\Services\Author;

use App\Models\Author;

class UpdateAuthorService
{
    public function __construct(private int $id, private string $name, private string $birthDate, private string $biography) {}

    public function execute(): Author
    {
        $author = Author::findOrFail($this->id);

        $author->update([
            'name' => $this->name,
            'birth_date' => $this->birthDate,
            'biography' => $this->biography,
        ]);

        return $author;
    }
}
