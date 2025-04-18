<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Services\Author\GetAuthorsService;
use App\Services\Author\CreateAuthorService;
use Inertia\Inertia;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class AuthorController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $authors = (new GetAuthorsService($request->input('search')))->execute();

        return inertia('Author/Index', ['authors' => AuthorResource::collection($authors)]);
    }

    public function store(CreateAuthorRequest $request): RedirectResponse
    {
        (new CreateAuthorService($request->validated('name')))->execute();

        return redirect('/authors');
    }

    public function show(int $id): InertiaResponse
    {
        $author = Author::findOrFail($id);

        return Inertia::render('Author/Show', new AuthorResource($author));
    }
}
