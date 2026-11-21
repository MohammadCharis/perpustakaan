<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FineController extends Controller
{
    public function index(): View
    {
        return view('fines.index', ['fines' => Fine::with('loan.member')->latest()->paginate(15)]);
    }

    public function update(Fine $fine): RedirectResponse
    {
        $fine->update(['status' => 'dibayar', 'paid_at' => now()]);
        return to_route('fines.index')->with('success', 'Denda berhasil dibayar.');
    }

    public function destroy(Fine $fine): RedirectResponse
    {
        $fine->delete();
        return to_route('fines.index')->with('success', 'Denda berhasil dihapus.');
    }
}
