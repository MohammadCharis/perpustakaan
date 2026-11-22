<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Book::class);

        return view('books.index', ['books' => Book::with('category')->latest()->paginate(12)]);
    }

    public function create(): View
    {
        $this->authorize('create', Book::class);

        return view('books.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(StoreBookRequest $request): RedirectResponse
    {
        $this->authorize('create', Book::class);
        Book::create($request->validated());

        return to_route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book): View
    {
        $this->authorize('update', $book);

        return view('books.edit', ['book' => $book, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(StoreBookRequest $request, Book $book): RedirectResponse
    {
        $this->authorize('update', $book);
        $book->update($request->validated());

        return to_route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $this->authorize('delete', $book);

        if ($book->loans()->whereNull('returned_at')->exists()) {
            return back()->with('error', 'Buku masih memiliki peminjaman aktif.');
        }

        try {
            $book->delete();
        } catch (QueryException) {
            return back()->with('error', 'Buku tidak dapat dihapus karena masih memiliki riwayat peminjaman.');
        }

        return to_route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
