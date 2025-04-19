<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }
    
    public function test_get_empty_authors(): void
    {
        $response = $this->get('/authors');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Author/Index')
                ->has('authors.data', 0)
            );
    }

    public function test_get_create_form_author(): void
    {
        $response = $this->get('/authors/create');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Author/Create')
            );
    }

    public function test_create_author(): void
    {
        $response = $this->post('/authors', $this->dummyAuthors->first());

        $response->assertRedirect('/authors');

        $this->assertDatabaseHas('authors', $this->dummyAuthors->first());
    }

    public function test_create_author_and_get_authors(): void
    {
        $response = $this->post('/authors', $this->dummyAuthors->first());

        $response->assertRedirect('/authors');

        $this->assertDatabaseHas('authors', $this->dummyAuthors->first());

        $response = $this->get('/authors');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Author/Index')
                ->count('authors.data', 1)
            );
    }

    public function test_get_edit_author_form(): void
    {
        $firstAuthor = $this->dummyAuthors->first();

        $this->post('/authors', $this->dummyAuthors->first())->assertRedirect('/authors');

        $response = $this->get("/authors/1/edit");

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Author/Edit')
                ->has('author')
                ->where('author.data.name', $firstAuthor['name'])
            );
    }

    public function test_update_author(): void
    {
        $this->post('/authors', $this->dummyAuthors->first())->assertRedirect('/authors');

        $response = $this->put('/authors/1', [
            'name' => 'Updated Author',
            'birth_date' => '1990-01-01',
            'biography' => 'Updated biography.',
        ]);

        $response->assertRedirect('/authors');

        $this->assertDatabaseHas('authors', [
            'name' => 'Updated Author',
            'birth_date' => '1990-01-01',
            'biography' => 'Updated biography.',
        ]);
    }

    public function test_destroy_author(): void
    {
        $this->post('/authors', $this->dummyAuthors->first())->assertRedirect('/authors');

        $response = $this->delete('/authors/1');

        $response->assertRedirect('/authors');

        $this->assertDatabaseMissing('authors', $this->dummyAuthors->first());
    }

    public function test_get_authors_with_search()
    {
        $this->post('/authors', $this->dummyAuthors->first())->assertRedirect('/authors');
        $this->post('/authors', $this->dummyAuthors->last())->assertRedirect('/authors');

        $response = $this->get('/authors?search=John');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Author/Index')
                ->has('authors.data', 1)
                ->where('authors.data.0.name', 'John Doe')
                ->where('authors.data.0.biography', 'Lorem')
                ->whereNot('authors.data.0.name', 'Jane Smith')
                ->whereNot('authors.data.0.biography', 'Ipsum')
            );
    }

    public function test_get_authors_with_asc_desc()
    {
        $this->post('/authors', $this->dummyAuthors->first())->assertRedirect('/authors');
        $this->post('/authors', $this->dummyAuthors->last())->assertRedirect('/authors');

        $response = $this->get('/authors?' . http_build_query([
            'page' => '',
            'search' => '',
            'sort' => [
                'column' => 'biography',
                'direction' => 'asc',
            ],
        ]));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Author/Index')
                ->has('authors.data', 2)
                ->where('authors.data.0.name', 'Jane Smith')
                ->where('authors.data.0.biography', 'Ipsum')
            );
    }

    public function test_get_authors_with_sort_desc()
    {
        $this->post('/authors', $this->dummyAuthors->first())->assertRedirect('/authors');
        $this->post('/authors', $this->dummyAuthors->last())->assertRedirect('/authors');

        $response = $this->get('/authors?' . http_build_query([
            'page' => '',
            'search' => '',
            'sort' => [
                'column' => 'biography',
                'direction' => 'desc',
            ],
        ]));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Author/Index')
                ->has('authors.data', 2)
                ->where('authors.data.0.name', 'John Doe')
                ->where('authors.data.0.biography', 'Lorem')
            );
    }
}
