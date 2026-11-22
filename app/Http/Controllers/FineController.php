<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FineController extends Controller
{
    public function index(): View
    {
        return view('fines.index', ['fines' => Fine::with('loan.member', 'loan.book')->latest()->paginate(15)]);
    }

    public function update(Fine $fine): RedirectResponse
    {
        if ($fine->status !== 'dibayar') {
            $fine->update(['status' => 'dibayar', 'paid_at' => now()]);
        }

        return to_route('fines.index')->with('success', 'Denda berhasil dibayar.');
    }

    public function destroy(Fine $fine): RedirectResponse
    {
        abort_unless(request()->user()?->isAdmin(), 403);
        $fine->delete();

        return to_route('fines.index')->with('success', 'Denda berhasil dihapus.');
    }
}
