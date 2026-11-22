<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function dashboard(Request $request): View
    {
        $period = $this->normalizePeriod((string) $request->query('period', $request->query('range', 'month')));

        [$start, $end] = $this->periodRange($period);

        $search = trim((string) $request->query('search', ''));
        $status = trim((string) $request->query('status', ''));

        $stats = [
            'books' => Book::count(),
            'members' => Member::where('is_active', true)->count(),
            'loans' => Loan::whereNull('returned_at')->whereBetween('loan_date', [$start, $end])->count(),
            'fines' => Fine::where('status', 'belum_dibayar')->sum('amount'),
        ];

        $categories = Category::withCount('books')->orderBy('name')->get();

        [$chartLabels, $chartData] = $this->chartData($period, $start, $end);

        $activities = Loan::query()
            ->with(['book', 'member'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($sub) use ($search): void {
                    $sub->whereHas('book', fn ($bookQuery) => $bookQuery->where('title', 'like', '%'.$search.'%'))
                        ->orWhereHas('member', fn ($memberQuery) => $memberQuery->where('name', 'like', '%'.$search.'%'));
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->whereBetween('loan_date', [$start, $end])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard', [
            'period' => $period,
            'stats' => $stats,
            'categories' => $categories,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'activities' => $activities,
            'search' => $search,
            'status' => $status,
            'recentLoans' => $activities,
        ]);
    }

    public function index(Request $request): View
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->string('start_date')->toString())->startOfDay()
            : null;
        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->string('end_date')->toString())->endOfDay()
            : null;

        if ($startDate && $endDate && $startDate->gt($endDate)) {
            [$startDate, $endDate] = [$endDate->copy()->startOfDay(), $startDate->copy()->endOfDay()];
        }

        $loans = Loan::query()
            ->with(['book', 'member'])
            ->when($startDate, fn ($query) => $query->where('loan_date', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->where('loan_date', '<=', $endDate))
            ->latest('loan_date')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('reports.index', [
            'loans' => $loans,
            'startDate' => $startDate?->toDateString(),
            'endDate' => $endDate?->toDateString(),
        ]);
    }

    private function normalizePeriod(string $period): string
    {
        $period = strtolower(trim($period));

        return match ($period) {
            'week', 'minggu', 'minggu ini', 'this week' => 'week',
            'year', 'tahun', 'tahun ini', 'this year' => 'year',
            default => 'month',
        };
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function periodRange(string $period): array
    {
        $now = Carbon::now();

        return match ($period) {
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };
    }

    /**
     * @return array{0: array<int,string>, 1: array<int,int>}
     */
    private function chartData(string $period, Carbon $start, Carbon $end): array
    {
        if ($period === 'year') {
            $rows = Loan::query()
                ->selectRaw("DATE_FORMAT(loan_date, '%Y-%m') as bucket, COUNT(*) as total")
                ->whereBetween('loan_date', [$start, $end])
                ->groupBy('bucket')
                ->pluck('total', 'bucket');

            $labels = [];
            $data = [];
            foreach (CarbonPeriod::create($start->copy()->startOfMonth(), '1 month', $end->copy()->startOfMonth()) as $date) {
                $key = $date->format('Y-m');
                $labels[] = $date->translatedFormat('M');
                $data[] = (int) ($rows[$key] ?? 0);
            }

            return [$labels, $data];
        }

        $rows = Loan::query()
            ->selectRaw('DATE(loan_date) as bucket, COUNT(*) as total')
            ->whereBetween('loan_date', [$start, $end])
            ->groupBy('bucket')
            ->pluck('total', 'bucket');

        $labels = [];
        $data = [];
        foreach (CarbonPeriod::create($start->copy()->startOfDay(), '1 day', $end->copy()->startOfDay()) as $date) {
            $key = $date->toDateString();
            $labels[] = $date->translatedFormat('d M');
            $data[] = (int) ($rows[$key] ?? 0);
        }

        if ($period === 'month' && count($labels) > 31) {
            // safety guard
        }

        return [$labels, $data];
    }
}
