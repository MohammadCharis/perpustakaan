<x-app-layout>
    <x-page-header title="Laporan Peminjaman" description="Laporan riwayat peminjaman berdasarkan periode.">
        <button type="button" onclick="window.print()" class="btn-secondary print:hidden">Cetak</button>
    </x-page-header>

    <section class="card mb-6 p-5 print:hidden">
        <form method="GET" action="{{ route('reports.index') }}" class="grid gap-4 sm:grid-cols-3">
            <div>
                <label for="start_date" class="mb-1 block text-sm font-medium text-ink">Tanggal awal</label>
                <input id="start_date" name="start_date" type="date" value="{{ $startDate }}" class="input">
            </div>
            <div>
                <label for="end_date" class="mb-1 block text-sm font-medium text-ink">Tanggal akhir</label>
                <input id="end_date" name="end_date" type="date" value="{{ $endDate }}" class="input">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="btn-primary">Tampilkan</button>
                <a href="{{ route('reports.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </section>

    <div class="table-wrap">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Jatuh Tempo</th>
                        <th>Dikembalikan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr>
                            <td>{{ $loan->loan_date?->translatedFormat('d F Y') ?? '-' }}</td>
                            <td>{{ $loan->member?->name ?? '-' }}</td>
                            <td class="font-medium text-ink">{{ $loan->book?->title ?? '-' }}</td>
                            <td>{{ $loan->due_date?->translatedFormat('d F Y') ?? '-' }}</td>
                            <td>{{ $loan->returned_at?->translatedFormat('d F Y') ?? '-' }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <x-status-dot :status="$loan->status->value" />
                                    <span>{{ $loan->status->label() }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-muted">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 print:hidden">{{ $loans->links() }}</div>

    <style>
        @media print {
            nav, header, .print\:hidden { display: none !important; }
            body { background: white; }
            .card, .table-wrap { box-shadow: none !important; border: 1px solid #ddd !important; }
        }
    </style>
</x-app-layout>
