<?php

namespace App\Services\Book;

use App\Contracts\GetBookImageInterface;
use App\Exceptions\AuthorForBookNotFoundException;
use App\Exceptions\NoBookImageFoundException;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\Cache;

class UpdateBookService
{
    private string $title;

    private string $isbn;

    private int $authorId;

    private int $id;

    private GetBookImageInterface $getBookImage;

    public function __construct(int $id, string $title, string $isbn, int $authorId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->isbn = $isbn;
        $this->authorId = $authorId;
        $this->getBookImage = app(GetBookImageInterface::class);
    }

    public function execute(): Book
    {
        $book = Book::findOrFail($this->id);
        $authorId = Author::firstWhere('id', $this->authorId);

        if (! $authorId) {
            throw new AuthorForBookNotFoundException(
                'Author not found for the book with ISBN: '.$this->isbn.' and author ID: '.$this->authorId
            );
        }

        if ($book->isbn !== $this->isbn) {
            $newImage = $this->getBookImage->getImageUrl($this->isbn);

            if (! $newImage) {
                throw new NoBookImageFoundException(
                    'No image found for the provided ISBN: '.$this->isbn
                );
            }

            $book->cover_url = $newImage;
        }

        $book = $book->update([
            'title' => $this->title,
            'isbn' => $this->isbn,
            'author_id' => $this->authorId,
            'cover_url' => $book->cover_url,
        ]);

        return Cache::remember($book->cacheKey(), 3600, function () use ($book) {
            return $book;
        });
    }
}
