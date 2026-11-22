<x-app-layout>
    <x-page-header title="Peminjaman Baru" description="Catat peminjaman buku baru." />

    <section class="card max-w-xl p-6">
        <form method="POST" action="{{ route('loans.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="book_id" class="mb-1 block text-sm font-medium text-ink">Buku</label>
                <select id="book_id" name="book_id" class="input">
                    <option value="">Pilih buku</option>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" @selected(old('book_id') == $book->id)>{{ $book->title }} (stok {{ $book->stock }})</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('book_id')" class="mt-1" />
            </div>

            <div>
                <label for="member_id" class="mb-1 block text-sm font-medium text-ink">Anggota</label>
                <select id="member_id" name="member_id" class="input">
                    <option value="">Pilih anggota</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>{{ $member->name }} ({{ $member->member_code }})</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('member_id')" class="mt-1" />
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">Simpan Peminjaman</button>
                <a href="{{ route('loans.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </section>
</x-app-layout>
