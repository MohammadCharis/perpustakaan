<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Peminjaman</h2>
            <a href="{{ route('loans.create') }}" class="rounded bg-indigo-600 px-4 py-2 text-white">Peminjaman baru</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8">
        <div class="overflow-x-auto rounded bg-white p-6 shadow">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="p-3">Buku</th>
                        <th class="p-3">Anggota</th>
                        <th class="p-3">Jatuh tempo</th>
                        <th class="p-3">Status</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr class="border-b {{ $loan->returned_at === null && $loan->due_date->isPast() ? 'bg-red-50' : '' }}">
                            <td class="p-3">{{ $loan->book->title }}</td>
                            <td class="p-3">{{ $loan->member->name }}</td>
                            <td class="p-3">{{ $loan->due_date->translatedFormat('d F Y') }}</td>
                            <td class="p-3">
                                {{ $loan->status->label() }}
                                @if ($loan->fine)
                                    <span class="text-red-600">· Denda Rp {{ number_format($loan->fine->amount, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td class="p-3 text-right">
                                @if (! $loan->returned_at)
                                    <form method="POST" action="{{ route('loans.return', $loan) }}">
                                        @csrf
                                        <button class="text-indigo-600">Kembalikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-gray-500">Belum ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $loans->links() }}</div>
        </div>
    </div>
</x-app-layout>

