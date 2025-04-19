<?php

namespace App\Services\Author;

use App\Models\Author;
use Illuminate\Support\Facades\Cache;

class CreateAuthorService
{
    public function __construct(private string $name, private string $birthDate, private string $biography) {}

    public function execute(): Author
    {
        $author = Author::create([
            'name' => $this->name,
            'birth_date' => $this->birthDate,
            'biography' => $this->biography,
        ]);

        return Cache::remember($author->cacheKey(), 3600, function () use ($author) {
            return $author;
        });
    }
}
