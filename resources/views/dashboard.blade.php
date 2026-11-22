<x-app-layout>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-ink">Ringkasan</h1>
            <p class="mt-1 text-sm text-muted">Ringkasan seluruh data perpustakaan.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <div class="inline-flex rounded-xl border border-line bg-surface p-1">
                @foreach (['month' => 'Bulan Ini', 'week' => 'Minggu Ini', 'year' => 'Tahun Ini'] as $value => $label)
                    <a href="{{ request()->fullUrlWithQuery(['period' => $value, 'page' => null]) }}" class="rounded-lg px-3 py-1.5 text-sm font-medium transition {{ $period === $value ? 'bg-brand text-white' : 'text-muted hover:text-ink' }}">{{ $label }}</a>
                @endforeach
            </div>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Reset</a>
        </div>
    </div>

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total Buku" :value="$stats['books']" icon="book-open" tone="green" class="bg-brand text-white" />
        <x-stat-card label="Anggota Aktif" :value="$stats['members']" icon="users" tone="brand" />
        <x-stat-card label="Sedang Dipinjam" :value="$stats['loans']" icon="arrows-right-left" tone="amber" />
        <x-stat-card label="Denda Belum Dibayar" :value="'Rp '.number_format((float) $stats['fines'], 0, ',', '.')" icon="banknotes" tone="rose" />
    </div>

    <div class="mb-6 grid gap-6 lg:grid-cols-3">
        <section class="card lg:col-span-2">
            <div class="flex items-center justify-between border-b border-line px-5 py-4">
                <div>
                    <h2 class="font-semibold text-ink">Peminjaman per Periode</h2>
                    <p class="text-sm text-muted">Data peminjaman aktual.</p>
                </div>
            </div>
            <div class="p-5">
                <div class="relative h-72 w-full">
                    <canvas id="loanChart"></canvas>
                </div>
            </div>
        </section>
        <section class="space-y-3">
            <h2 class="font-semibold text-ink">Kategori</h2>
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                @forelse ($categories as $category)
                    <x-category-tile :name="$category->name" :count="$category->books_count" href="{{ route('books.index') }}" />
                @empty
                    <div class="card p-4 text-sm text-muted">Belum ada kategori.</div>
                @endforelse
            </div>
        </section>
    </div>

    <section class="card">
        <div class="flex flex-col gap-4 border-b border-line px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-ink">Aktivitas Terbaru</h2>
                <p class="text-sm text-muted">Peminjaman terbaru di perpustakaan.</p>
            </div>
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="period" value="{{ $period }}">
                <div class="relative">
                    <x-heroicon name="magnifying-glass" class="absolute left-3 top-2.5 h-4 w-4 text-muted" />
                    <input name="search" value="{{ $search }}" class="input pl-9" placeholder="Cari buku atau anggota..." />
                </div>
                <select name="status" class="input w-auto">
                    <option value="">Semua status</option>
                    @foreach (['dipinjam', 'dikembalikan', 'terlambat'] as $option)
                        <option value="{{ $option }}" @selected($status === $option)>{{ ucfirst($option) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-secondary">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-canvas">
                    <tr>
                        <th class="w-10 px-5 py-3"><input type="checkbox" class="rounded border-line text-brand focus:ring-brand" aria-label="Pilih semua" /></th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted">Buku</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted">Anggota</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $loan)
                        <tr class="border-t border-line transition hover:bg-canvas">
                            <td class="px-5 py-4"><input type="checkbox" value="{{ $loan->id }}" class="rounded border-line text-brand focus:ring-brand" aria-label="Pilih peminjaman" /></td>
                            <td class="px-5 py-4 font-medium text-ink">{{ $loan->book?->title ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <x-avatar :name="$loan->member?->name ?? '-'" size="sm" />
                                    <span>{{ $loan->member?->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-muted">{{ optional($loan->loan_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <x-status-dot :status="$loan->status->value" />
                                    <span class="text-sm">{{ $loan->status->label() }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-muted">Belum ada peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-line px-5 py-4">
            {{ $activities->links() }}
        </div>
    </section>

    <script>
        (function () {
            const ctx = document.getElementById('loanChart');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Peminjaman',
                        data: @json($chartData),
                        backgroundColor: 'rgba(41, 121, 255, 0.20)',
borderColor: '#2979FF',
borderWidth: 2,
                        borderRadius: 8,
                        maxBarThickness: 28,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        })();
    </script>
</x-app-layout>