<x-app-layout>
    <x-page-header title="Peminjaman" description="Daftar peminjaman buku.">
        <a href="{{ route('loans.create') }}" class="btn-primary">+ Tambah Peminjaman</a>
    </x-page-header>

    <div class="table-wrap">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Anggota</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr class="{{ $loan->returned_at === null && $loan->due_date->isPast() ? 'bg-rose-50' : '' }}">
                            <td class="font-medium text-ink">{{ $loan->book?->title ?? '-' }}</td>
                            <td>{{ $loan->member?->name ?? '-' }}</td>
                            <td>{{ $loan->due_date->translatedFormat('d F Y') }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <x-status-dot :status="$loan->status->value" />
                                    <span>{{ $loan->status->label() }}</span>
                                    @if ($loan->fine)
                                        <span class="text-status-danger">Denda Rp {{ number_format($loan->fine->amount, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-right">
                                @if (! $loan->returned_at)
                                    <form method="POST" action="{{ route('loans.return', $loan) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-primary">Kembalikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-muted">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $loans->links() }}</div>
</x-app-layout>
