<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\View\View;
class ReportController extends Controller { public function dashboard(): View { return view('dashboard', ['stats' => ['books' => Book::count(), 'members' => Member::where('active', true)->count(), 'loans' => Loan::whereNull('returned_at')->count(), 'fines' => Fine::where('status', 'unpaid')->sum('amount')], 'recentLoans' => Loan::with(['book', 'member'])->latest()->limit(8)->get()]); } public function index(): View { return view('reports.index', ['loans' => Loan::with(['book', 'member'])->latest()->paginate(20)]); } }
