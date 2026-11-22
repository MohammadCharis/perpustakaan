<x-app-layout>
    <x-page-header title="Buku" description="Daftar buku perpustakaan.">
        <a href="{{ route('books.create') }}" class="btn-primary">+ Tambah Buku</a>
    </x-page-header>

    <div class="table-wrap">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td class="font-medium text-ink">{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category?->name ?? '-' }}</td>
                            <td>{{ $book->stock }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('books.edit', $book) }}" class="btn-secondary">Ubah</a>
                                    @if (auth()->user()->isAdmin())
                                        <form method="POST" action="{{ route('books.destroy', $book) }}" class="inline">
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
                            <td colspan="5" class="py-10 text-center text-muted">Belum ada buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $books->links() }}</div>
</x-app-layout>
