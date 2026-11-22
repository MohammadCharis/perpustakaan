<header class="flex h-16 shrink-0 items-center gap-3 border-b border-line bg-surface px-4 sm:px-6">
    <button @click="open = !open" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-muted hover:bg-canvas hover:text-ink lg:hidden" aria-label="Buka navigasi">
        <x-heroicon name="bars-3" />
    </button>

    <div class="flex items-center gap-1">
        <button type="button" onclick="window.history.back()" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-muted transition hover:bg-canvas hover:text-ink" aria-label="Kembali">
            <x-heroicon name="chevron-left" />
        </button>
        <button type="button" onclick="window.history.forward()" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-muted transition hover:bg-canvas hover:text-ink" aria-label="Maju">
            <x-heroicon name="chevron-right" />
        </button>
    </div>

    <x-breadcrumb />

    <div class="ml-auto flex items-center gap-2">
        <x-icon-button icon="magnifying-glass" label="Cari" />
        <x-icon-button icon="envelope" label="Surat" />
        <x-icon-button icon="bell" label="Notifikasi" />

        <x-dropdown align="right" width="56">
            <x-slot:trigger>
                <button type="button" class="flex items-center gap-2 rounded-xl px-2 py-1.5 transition hover:bg-canvas">
                    <x-avatar :name="auth()->user()->name" size="sm" />
                    <span class="hidden text-left sm:block">
                        <span class="block text-sm font-semibold text-ink">{{ auth()->user()->name }}</span>
                        <span class="block text-xs text-muted">{{ auth()->user()->role === 'admin' ? 'Administrator' : 'Petugas' }}</span>
                    </span>
                </button>
            </x-slot:trigger>
            <x-slot:content>
                <div class="px-4 py-3">
                    <div class="text-sm font-semibold text-ink">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-muted">{{ auth()->user()->email }}</div>
                    <span class="mt-1 inline-flex rounded-full bg-brand-50 px-2 py-0.5 text-[10px] font-bold text-brand">{{ auth()->user()->role === 'admin' ? 'Administrator' : 'Petugas' }}</span>
                </div>
                <div class="border-t border-line"></div>
                <x-dropdown-link href="{{ route('profile.edit') }}">Profil Saya</x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-ink transition hover:bg-canvas">Keluar</button>
                </form>
            </x-slot:content>
        </x-dropdown>
    </div>
</header>