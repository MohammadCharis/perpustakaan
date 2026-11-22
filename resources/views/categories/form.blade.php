<x-app-layout>
    <x-page-header title="{{ isset($category) ? 'Ubah Kategori' : 'Tambah Kategori' }}" description="Lengkapi data kategori." />

    <section class="card max-w-xl p-6">
        <form method="POST" action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}" class="space-y-5">
            @csrf
            @isset($category)
                @method('PUT')
            @endisset

            <div>
                <label for="name" class="mb-1 block text-sm font-medium text-ink">Nama kategori</label>
                <input id="name" name="name" value="{{ old('name', $category->name ?? '') }}" class="input" placeholder="Nama kategori">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-ink">Deskripsi</label>
                <textarea id="description" name="description" class="input" rows="4" placeholder="Deskripsi">{{ old('description', $category->description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">{{ isset($category) ? 'Simpan Perubahan' : 'Simpan' }}</button>
                <a href="{{ route('categories.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </section>
</x-app-layout>
