<?php

namespace App\Services\Author;

use App\Models\Author;
use Illuminate\Support\Facades\Cache;

class UpdateAuthorService
{
    public function __construct(private int $id, private string $name, private string $birthDate, private string $biography) {}

    public function execute(): Author
    {
        $author = Author::findOrFail($this->id);

        $cacheKey = $author->cacheKey();

        $author->update([
            'name' => $this->name,
            'birth_date' => $this->birthDate,
            'biography' => $this->biography,
        ]);

        return Cache::remember($cacheKey, 3600, function () use ($author) {
            return $author;
        });
    }
}
