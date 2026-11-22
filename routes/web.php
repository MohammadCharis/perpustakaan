<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));
Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [ReportController::class, 'dashboard'])->name('dashboard');
    Route::resource('books', BookController::class)->except(['show', 'destroy']);
    Route::resource('loans', LoanController::class)->only(['index', 'create', 'store']);
    Route::post('/loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::resource('members', MemberController::class)->except(['show', 'destroy']);
    Route::resource('fines', FineController::class)->only(['index', 'update']);
    Route::middleware('admin')->group(function (): void {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::delete('members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
        Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
        Route::delete('fines/{fine}', [FineController::class, 'destroy'])->name('fines.destroy');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
