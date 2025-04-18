<?php

namespace App\Services\Book;

use App\Exceptions\AuthorForBookNotFoundException;
use App\Exceptions\NoBookImageFoundException;
use App\Models\Author;
use App\Models\Book;

class CreateBookService
{
    private string $name;

    private string $isbn;

    private int $authorId;

    private GetBookImageInterface $getBookImage;

    public function __construct(string $name, string $isbn, int $authorId)
    {
        $this->name = $name;
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

        return Book::create([
            'name' => $this->name,
            'isbn' => $this->isbn,
            'image' => $imageUrl,
            'author_id' => $this->authorId,
        ]);
    }
}
