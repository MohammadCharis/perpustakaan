<x-app-layout>
    <x-page-header title="{{ isset($book) ? 'Ubah Buku' : 'Tambah Buku' }}" description="Lengkapi data buku." />

    <section class="card max-w-3xl p-6">
        <form method="POST" action="{{ isset($book) ? route('books.update', $book) : route('books.store') }}" class="space-y-5">
            @csrf
            @isset($book)
                @method('PUT')
            @endisset

            @foreach ([['title', 'Judul'], ['author', 'Penulis'], ['isbn', 'ISBN'], ['published_year', 'Tahun terbit'], ['stock', 'Stok']] as [$name, $label])
                <div>
                    <label for="{{ $name }}" class="mb-1 block text-sm font-medium text-ink">{{ $label }}</label>
                    <input id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $book->$name ?? '') }}" class="input">
                    <x-input-error :messages="$errors->get($name)" class="mt-1" />
                </div>
            @endforeach

            <div>
                <label for="category_id" class="mb-1 block text-sm font-medium text-ink">Kategori</label>
                <select id="category_id" name="category_id" class="input">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
            </div>

            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-ink">Deskripsi</label>
                <textarea id="description" name="description" class="input" rows="4">{{ old('description', $book->description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">{{ isset($book) ? 'Simpan Perubahan' : 'Simpan' }}</button>
                <a href="{{ route('books.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </section>
</x-app-layout>
