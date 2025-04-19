<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Collection;

abstract class TestCase extends BaseTestCase
{
    protected Collection $dummyAuthors;

    protected Collection $dummyBooks;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dummyAuthors = collect([
            [
                'name' => 'John Doe',
                'birth_date' => '1990-01-01',
                'biography' => 'Lorem',
            ],
            [
                'name' => 'Jane Smith',
                'birth_date' => '1985-05-15',
                'biography' => 'Ipsum',
            ],
        ]);

        $this->dummyBooks = collect([
            [
                'title' => 'Book One',
                'isbn' => '978-0553593716',
                'author_id' => 1,
            ],
            [
                'title' => 'Book Two',
                'isbn' => '978-0553593716',
                'author_id' => 2,
            ],
        ]);
    }
}
