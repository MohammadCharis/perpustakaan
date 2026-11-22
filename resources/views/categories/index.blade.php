<x-app-layout>
    <x-page-header title="Kategori" description="Kelola kategori buku.">
        @if (auth()->user()->isAdmin())
            <a href="{{ route('categories.create') }}" class="btn-primary">+ Tambah Kategori</a>
        @endif
    </x-page-header>

    <div class="table-wrap">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah Buku</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="font-medium text-ink">{{ $category->name }}</td>
                            <td>{{ $category->books_count }}</td>
                            <td class="text-right">
                                @if (auth()->user()->isAdmin())
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="btn-secondary">Ubah</a>
                                        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-secondary text-status-danger">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-10 text-center text-muted">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
</x-app-layout>
