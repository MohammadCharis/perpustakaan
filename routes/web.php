<?php
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
Route::get('/', fn () => to_route('dashboard'));
Route::middleware('auth')->group(function (): void { Route::get('/dashboard', [ReportController::class, 'dashboard'])->name('dashboard'); Route::resource('books', BookController::class)->except(['show']); Route::get('/reports', [ReportController::class, 'index'])->name('reports.index'); });
require __DIR__.'/auth.php';
