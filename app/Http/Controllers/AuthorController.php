<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Services\Author\CreateAuthorService;
use App\Services\Author\GetAuthorService;
use App\Services\Author\GetAuthorsService;
use App\Services\Author\UpdateAuthorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class AuthorController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $authors = (new GetAuthorsService(
            $request->input('search'),
            $request->input('sort'),
        ))->execute();

        return inertia('Author/Index', ['authors' => AuthorResource::collection($authors)]);
    }

    public function store(CreateAuthorRequest $request): RedirectResponse
    {
        (new CreateAuthorService(
            $request->validated('name'),
            $request->validated('birth_date'),
            $request->validated('biography')
        ))->execute();

        return redirect('/authors');
    }

    public function show(int $id): InertiaResponse
    {

        $author = (new GetAuthorService(
            $id
        ))->execute();

        return Inertia::render('Author/Show', ['author' => new AuthorResource($author)]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Author/Create');
    }

    public function edit(int $id): InertiaResponse
    {
        $author = Author::findOrFail($id);

        return Inertia::render('Author/Edit', ['author' => new AuthorResource($author)]);
    }

    public function update(UpdateAuthorRequest $request, int $id): RedirectResponse
    {
        (new UpdateAuthorService(
            $id,
            $request->validated('name'),
            $request->validated('birth_date'),
            $request->validated('biography')
        ))->execute();

        return redirect('/authors');
    }

    public function destroy(int $id): RedirectResponse
    {
        Author::destroy($id);

        return redirect('/authors');
    }
}
