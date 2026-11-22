<x-app-layout>
    <x-page-header title="Anggota" description="Daftar anggota perpustakaan.">
        <a href="{{ route('members.create') }}" class="btn-primary">+ Tambah Anggota</a>
    </x-page-header>

    <div class="table-wrap">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Peminjaman</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td class="font-medium text-ink">{{ $member->member_code }}</td>
                            <td>{{ $member->name }}</td>
                            <td>
                                <x-badge :variant="$member->is_active ? 'success' : 'default'">{{ $member->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge>
                            </td>
                            <td>{{ $member->loans_count }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('members.edit', $member) }}" class="btn-secondary">Ubah</a>
                                    @if (auth()->user()->isAdmin())
                                        <form method="POST" action="{{ route('members.destroy', $member) }}" class="inline">
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
                            <td colspan="5" class="py-10 text-center text-muted">Belum ada anggota.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $members->links() }}</div>
</x-app-layout>
