<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Category::class);

        return view('categories.index', ['categories' => Category::withCount('books')->latest()->paginate(15)]);
    }

    public function create(): View
    {
        $this->authorize('create', Category::class);

        return view('categories.form');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->authorize('create', Category::class);
        Category::create($request->validated());

        return to_route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        $this->authorize('update', $category);

        return view('categories.form', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);
        $category->update($request->validated());

        return to_route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);

        if ($category->books()->exists()) {
            return back()->with('error', 'Kategori masih digunakan buku.');
        }

        $category->delete();

        return to_route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
