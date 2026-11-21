<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Laporan Peminjaman</h2>
            <button type="button" onclick="window.print()" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white print:hidden">Cetak</button>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8">
        <form method="GET" class="mb-6 grid gap-4 rounded-lg bg-white p-6 shadow sm:grid-cols-3 print:hidden">
            <div>
                <label for="start_date" class="mb-1 block text-sm font-medium text-gray-700">Tanggal awal</label>
                <input id="start_date" name="start_date" type="date" value="{{ request('start_date') }}" class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label for="end_date" class="mb-1 block text-sm font-medium text-gray-700">Tanggal akhir</label>
                <input id="end_date" name="end_date" type="date" value="{{ request('end_date') }}" class="w-full rounded-md border-gray-300">
            </div>
            <div class="flex items-end gap-2">
                <button class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Tampilkan</button>
                <a href="{{ route('reports.index') }}" class="rounded border px-4 py-2 text-sm">Reset</a>
            </div>
        </form>

        <div class="overflow-x-auto rounded-lg bg-white p-6 shadow">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="px-3 py-3">Tanggal</th>
                        <th class="px-3 py-3">Anggota</th>
                        <th class="px-3 py-3">Buku</th>
                        <th class="px-3 py-3">Jatuh tempo</th>
                        <th class="px-3 py-3">Dikembalikan</th>
                        <th class="px-3 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr class="border-b">
                            <td class="px-3 py-3">{{ $loan->loan_date->translatedFormat('d F Y') }}</td>
                            <td class="px-3 py-3">{{ $loan->member->name }}</td>
                            <td class="px-3 py-3">{{ $loan->book->title }}</td>
                            <td class="px-3 py-3">{{ $loan->due_date->translatedFormat('d F Y') }}</td>
                            <td class="px-3 py-3">{{ $loan->returned_at?->translatedFormat('d F Y') ?? '-' }}</td>
                            <td class="px-3 py-3">{{ $loan->status->label() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-3 py-8 text-center text-gray-500">Belum ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $loans->withQueryString()->links() }}</div>
        </div>
    </div>

    <style>
        @media print {
            nav, header, form, button { display: none !important; }
            body { background: white; }
            .shadow { box-shadow: none !important; }
        }
    </style>
</x-app-layout>
