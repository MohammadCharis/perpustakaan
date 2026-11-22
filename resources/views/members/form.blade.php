<x-app-layout>
    <x-page-header title="{{ isset($member) ? 'Ubah Anggota' : 'Tambah Anggota' }}" description="Lengkapi data anggota." />

    <section class="card max-w-xl p-6">
        <form method="POST" action="{{ isset($member) ? route('members.update', $member) : route('members.store') }}" class="space-y-5">
            @csrf
            @isset($member)
                @method('PUT')
            @endisset

            @foreach ([['member_code', 'Kode anggota', 'text'], ['name', 'Nama', 'text'], ['email', 'Email', 'email'], ['phone', 'Telepon', 'text'], ['joined_at', 'Tanggal bergabung', 'date']] as [$field, $label, $type])
                <div>
                    <label for="{{ $field }}" class="mb-1 block text-sm font-medium text-ink">{{ $label }}</label>
                    <input id="{{ $field }}" name="{{ $field }}" type="{{ $type }}" value="{{ old($field, isset($member?->$field) ? (string) $member->$field : '') }}" class="input" placeholder="{{ $label }}">
                    <x-input-error :messages="$errors->get($field)" class="mt-1" />
                </div>
            @endforeach

            <div>
                <label for="address" class="mb-1 block text-sm font-medium text-ink">Alamat</label>
                <textarea id="address" name="address" class="input" rows="3" placeholder="Alamat">{{ old('address', $member->address ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-1" />
            </div>

            <label class="flex items-center gap-2 text-sm text-ink">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $member->is_active ?? true)) class="rounded border-line text-brand focus:ring-brand">
                Aktif
            </label>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">{{ isset($member) ? 'Simpan Perubahan' : 'Simpan' }}</button>
                <a href="{{ route('members.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </section>
</x-app-layout>
