<?php

namespace App\Services\Book;

use App\Contracts\GetBookImageInterface;
use App\Exceptions\AuthorForBookNotFoundException;
use App\Exceptions\NoBookImageFoundException;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\Cache;

class CreateBookService
{
    private string $title;

    private string $isbn;

    private int $authorId;

    private GetBookImageInterface $getBookImage;

    public function __construct(string $title, string $isbn, int $authorId)
    {
        $this->title = $title;
        $this->isbn = $isbn;
        $this->authorId = $authorId;
        $this->getBookImage = app(GetBookImageInterface::class);
    }

    public function execute(): Book
    {
        $authorId = Author::firstWhere('id', $this->authorId);

        if (! $authorId) {
            throw new AuthorForBookNotFoundException('Author not found for the book with ISBN: '.$this->isbn.' and author ID: '.$this->authorId);
        }

        $imageUrl = $this->getBookImage->getImageUrl($this->isbn);

        if (! $imageUrl) {
            throw new NoBookImageFoundException('No image found for the book with ISBN: '.$this->isbn);
        }

        $book = Book::create([
            'title' => $this->title,
            'isbn' => $this->isbn,
            'cover_url' => $imageUrl,
            'author_id' => $this->authorId,
        ]);

        return Cache::remember($book->cacheKey(), 3600, function () use ($book) {
            return $book;
        });
    }
}
