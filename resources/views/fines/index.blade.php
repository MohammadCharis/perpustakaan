<x-app-layout>
    <x-page-header title="Denda" description="Daftar denda perpustakaan.">
        <a href="{{ route('reports.index') }}" class="btn-secondary">Lihat Laporan</a>
    </x-page-header>

    <div class="table-wrap">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Hari Terlambat</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fines as $fine)
                        <tr>
                            <td>{{ $fine->loan?->member?->name ?? '-' }}</td>
                            <td>{{ $fine->loan?->book?->title ?? '-' }}</td>
                            <td>{{ $fine->days_late }}</td>
                            <td>Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                            <td>
                                <x-badge :variant="$fine->status === 'dibayar' ? 'success' : 'danger'">{{ $fine->status === 'dibayar' ? 'Lunas' : 'Belum Bayar' }}</x-badge>
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    @if ($fine->status !== 'dibayar')
                                        <form method="POST" action="{{ route('fines.update', $fine) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-primary">Bayar</button>
                                        </form>
                                    @endif
                                    @if (auth()->user()->isAdmin())
                                        <form method="POST" action="{{ route('fines.destroy', $fine) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-secondary text-status-danger">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-muted">Belum ada denda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $fines->links() }}</div>
</x-app-layout>
