<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Services\Author\AuthorService;

class AuthorController extends Controller
{
    private AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index()
    {
        return $this->authorService->listAuthors();
    }

    public function show(Author $author)
    {
        return $this->authorService->getAuthor($author);
    }

    public function save(?Author $author = null)
    {
        return $this->authorService->save($author);
    }

    public function destroy(Author $author)
    {
        return $this->authorService->destroy($author);
    }
}
