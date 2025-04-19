<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\Book\CreateBookService;
use App\Services\Book\GetAuthorsForBooks;
use App\Services\Book\GetBookService;
use App\Services\Book\GetBooksService;
use App\Services\Book\UpdateBookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class BookController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $books = (new GetBooksService($request->input('search'), $request->input('sort')))->execute();

        return Inertia::render('Book/Index', [
            'books' => BookResource::collection($books),
        ]);
    }

    public function store(CreateBookRequest $request): RedirectResponse
    {
        (new CreateBookService(
            $request->validated('title'),
            $request->validated('isbn'),
            $request->validated('author_id')
        ))->execute();

        return redirect('/books');
    }

    public function show(int $id): InertiaResponse
    {
        $book = (new GetBookService($id))->execute();

        return Inertia::render('Book/Show', [
            'book' => new BookResource($book),
        ]);
    }

    public function create(Request $request): InertiaResponse
    {
        $authors = (new GetAuthorsForBooks($request->input('search')))->execute();

        return Inertia::render('Book/Create', ['authors' => AuthorResource::collection($authors)]);
    }

    public function edit(Request $request, int $id): InertiaResponse
    {
        $book = Book::with('author')->findOrFail($id);
        $authors = (new GetAuthorsForBooks($request->input('search')))->execute();

        return Inertia::render('Book/Edit', [
            'book' => new BookResource($book),
            'authors' => AuthorResource::collection($authors),
        ]);
    }

    public function update(UpdateBookRequest $request, int $id): RedirectResponse
    {
        (new UpdateBookService(
            $id,
            $request->validated('title'),
            $request->validated('isbn'),
            $request->validated('author_id')
        ))->execute();

        return redirect('/books');
    }

    public function destroy(int $id): RedirectResponse
    {
        Book::destroy($id);

        return redirect('/books');
    }
}
