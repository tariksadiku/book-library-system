<?php

namespace Tests\Feature;

use App\Contracts\GetBookImageInterface;
use App\Models\Author;
use App\Services\Book\MockGetBookImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->bind(GetBookImageInterface::class, MockGetBookImageService::class);
    }

    public function test_get_empty_books(): void
    {
        // $this->createAuthors();
        $response = $this->get('/books');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Book/Index')
                ->has('books.data', 0)
            );
    }

    public function test_get_create_form_book(): void
    {
        $this->createAuthors();

        $response = $this->get('/books/create');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Book/Create')
                ->has('authors.data', 2)
            );
    }

    public function test_create_book(): void
    {
        $this->createAuthors();

        $response = $this->post('/books', $this->dummyBooks->first());

        $response->assertRedirect('/books');

        $this->assertDatabaseHas('books', $this->dummyBooks->first());
    }

    public function test_create_book_and_get_books(): void
    {
        $this->createAuthors();

        $response = $this->post('/books', $this->dummyBooks->first());

        $response->assertRedirect('/books');

        $this->assertDatabaseHas('books', $this->dummyBooks->first());

        $response = $this->get('/books');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Book/Index')
                ->has('books.data', 1)
            );
    }

    public function test_get_edit_book_form()
    {
        $this->createAuthors();
        $this->post('/books', $this->dummyBooks->first())->assertRedirect('/books');

        $response = $this->get('/books/1/edit');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Book/Edit')
                ->has('book', 1)
                ->has('authors.data', 2)
            );
    }

    public function test_edit_book()
    {
        $this->createAuthors();
        $this->post('/books', $this->dummyBooks->first())->assertRedirect('/books');

        $response = $this->put('/books/1', [
            'title' => 'Updated Book Title',
            'isbn' => '978-0553593716',
            'author_id' => 2,
        ]);

        $response->assertRedirect('/books');

        $this->assertDatabaseHas('books', [
            'title' => 'Updated Book Title',
            'isbn' => '978-0553593716',
            'author_id' => 2,
        ]);
    }

    public function test_destroy_book()
    {
        $this->createAuthors();
        $this->post('/books', $this->dummyBooks->first())->assertRedirect('/books');

        $response = $this->delete('/books/1');

        $response->assertRedirect('/books');

        $this->assertDatabaseMissing('books', [
            'title' => 'Book One',
            'isbn' => '978-0553593716',
            'author_id' => 1,
        ]);
    }

    public function test_get_books_with_search()
    {
        $this->createAuthors();
        $this->post('/books', $this->dummyBooks->first())->assertRedirect('/books');
        $this->post('/books', $this->dummyBooks->last())->assertRedirect('/books');

        $response = $this->get('/books?search=One');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Book/Index')
                ->has('books.data', 1)
                ->where('books.data.0.title', 'Book One')
                ->whereNot('books.data.0.title', 'Book Two')
            );
    }

    public function test_get_books_with_asc_desc()
    {
        $this->createAuthors();
        $this->post('/books', $this->dummyBooks->first())->assertRedirect('/books');
        $this->post('/books', $this->dummyBooks->last())->assertRedirect('/books');

        $response = $this->get('/books?'.http_build_query([
            'page' => '',
            'search' => '',
            'sort' => [
                'column' => 'title',
                'direction' => 'asc',
            ],
        ]));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Book/Index')
                ->has('books.data', 2)
                ->where('books.data.0.title', 'Book One')
            );
    }

    public function test_get_authors_with_sort_desc()
    {
        $this->createAuthors();
        $this->post('/books', $this->dummyBooks->first())->assertRedirect('/books');
        $this->post('/books', $this->dummyBooks->last())->assertRedirect('/books');

        $response = $this->get('/books?'.http_build_query([
            'page' => '',
            'search' => '',
            'sort' => [
                'column' => 'title',
                'direction' => 'desc',
            ],
        ]));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Book/Index')
                ->has('books.data', 2)
                ->where('books.data.0.title', 'Book Two')
            );
    }

    private function createAuthors(): Collection
    {
        return $this->dummyAuthors->map(function ($author) {
            return Author::create([
                'name' => $author['name'],
                'birth_date' => $author['birth_date'],
                'biography' => $author['biography'],
            ]);
        });
    }
}
