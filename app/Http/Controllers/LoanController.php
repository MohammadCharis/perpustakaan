<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\LoanService;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function index(): View
    {
        return view('loans.index', ['loans' => Loan::with(['book', 'member', 'fine'])->latest()->paginate(15)]);
    }

    public function create(): View
    {
        return view('loans.create', ['books' => Book::where('stock', '>', 0)->orderBy('title')->get(), 'members' => Member::where('is_active', true)->orderBy('name')->get()]);
    }

    public function store(StoreLoanRequest $request, LoanService $service): RedirectResponse
    {
        $service->loan(Book::findOrFail($request->integer('book_id')), Member::findOrFail($request->integer('member_id')), $request->user()->id);

        return to_route('loans.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function return(Loan $loan, LoanService $service): RedirectResponse
    {
        $service->return($loan);

        return to_route('loans.index')->with('success', 'Buku berhasil dikembalikan.');
    }
}
