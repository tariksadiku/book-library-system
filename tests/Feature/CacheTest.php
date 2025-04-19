<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CacheTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_cache(): void
    {   
        $author = Author::create($this->dummyAuthors->first());

        Cache::remember($author->cacheKey(), 60, function () use ($author) {
            return $author;
        });

        $author->update(['name' => 'Updated Author']);

        $this->assertEquals('Updated Author', Cache::get($author->cacheKey())->name);

    }

    public function test_book_cache(): void
    {
        $author = Author::create($this->dummyAuthors->first());

        Cache::remember($author->cacheKey(), 60, function () use ($author) {
            return $author;
        });

        $book = Book::create(array_merge($this->dummyBooks->first(), ['cover_url' => 'https://example.com/cover.jpg']));

        Cache::remember($book->cacheKey(), 60, function () use ($book) {
            return $book;
        });

        $this->assertEquals("Book One", Cache::get($book->cacheKey())->title);
        $this->assertEquals(1, Cache::get($book->cacheKey())->author_id);

        $author->update(['name' => 'Updated Author']);

        // Should be null since on Author updates the book cache is cleared
        $this->assertNull(Cache::get($book->cacheKey()));
        $this->assertNull(Cache::get($author->cacheKey()));

        // These would be cached again now through our API's
        Cache::remember($author->cacheKey(), 60, function () use ($author) {
            return $author;
        });
        Cache::remember($book->cacheKey(), 60, function () use ($book) {
            return $book;
        }); 

        // Now we can check if the author cache is updated
        $this->assertEquals('Updated Author', Cache::get($author->cacheKey())->name);
    }
}
