<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Resources\BookResource;
use App\Services\Book\GetBooksService;
use Illuminate\Http\Request;
use App\Services\Book\CreateBookService;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class BookController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $books = (new GetBooksService($request->input('search')))->execute();

        return Inertia::render('Book/Index', [
            'books' => BookResource::collection($books),
        ]);
    }

    public function store(CreateBookRequest $request): RedirectResponse
    {
        (new CreateBookService(
            $request->validated('name'),
            $request->validated('isbn'),
            $request->validated('author_id')
        ))->execute();

       return redirect('/books');
    }

    public function show(int $id): InertiaResponse
    {
        $book = Book::findOrFail($id);
        return Inertia::render('Book/Show', [
            'book' => $book,
        ]);
    }
}
