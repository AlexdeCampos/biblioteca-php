<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\Book\BookService;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        return $this->bookService->listBooks();
    }

    public function show(Book $book)
    {
        return $this->bookService->getBook($book);
    }

    public function save(?Book $book = null)
    {
        return $this->bookService->save($book);
    }

    public function destroy(Book $book)
    {
        return $this->bookService->destroy($book);
    }
}
