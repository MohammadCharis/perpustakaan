<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
class BookController extends Controller { public function index(): View { return view('books.index', ['books' => Book::with('category')->latest()->paginate(12)]); } public function create(): View { return view('books.create', ['categories' => Category::orderBy('name')->get()]); } public function store(StoreBookRequest $request): RedirectResponse { Book::create($request->validated()); return to_route('books.index')->with('success', 'Book created.'); } public function edit(Book $book): View { return view('books.edit', ['book' => $book, 'categories' => Category::orderBy('name')->get()]); } public function update(StoreBookRequest $request, Book $book): RedirectResponse { $book->update($request->validated()); return to_route('books.index')->with('success', 'Book updated.'); } public function destroy(Book $book): RedirectResponse { $book->delete(); return to_route('books.index')->with('success', 'Book deleted.'); } }
