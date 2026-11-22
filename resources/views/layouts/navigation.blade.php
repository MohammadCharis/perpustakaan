@php
$activeLoansCount = \App\Models\Loan::whereNull('returned_at')->count();
$overdueCount = \App\Models\Loan::where(function ($query) {
    $query->where('status', 'terlambat')
        ->orWhere(function ($sub) {
            $sub->whereNull('returned_at')->whereDate('due_date', '<', now());
        });
})->count();
$isAdmin = auth()->user()?->role === 'admin';
@endphp
<aside x-show="open || window.innerWidth >= 1024" x-transition class="fixed inset-y-0 left-0 z-40 flex h-full min-h-0 w-64 flex-col overflow-hidden border-r border-line bg-surface lg:static lg:inset-auto">
        <div class="flex items-center gap-3 px-4 pt-4">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand font-bold text-white shadow-sm">P</div>
            <div class="min-w-0">
                <div class="truncate text-sm font-semibold tracking-tight text-ink">Perpustakaan</div>
                <div class="truncate text-[11px] text-muted">Library management</div>
            </div>
        </div>

        <div class="px-5 pt-4">
            <label class="relative block">
                <x-heroicon name="magnifying-glass" class="absolute left-3 top-2.5 h-4 w-4 text-muted" />
                <input type="search" class="input pl-9 pr-14 text-sm" placeholder="Cari" />
                <span class="absolute right-2 top-1.5 rounded-md border border-line bg-canvas px-1.5 py-0.5 text-[10px] font-semibold text-muted">Ctrl K</span>
            </label>
        </div>

        <nav class="mt-4 min-h-0 flex-1 space-y-5 overflow-y-auto px-3 pb-4">
            <div>
                <div class="mb-1.5 px-2 text-[10px] font-bold uppercase tracking-widest text-muted">MAIN MENU</div>
                <div class="space-y-1">
                    <x-sidebar-link href="{{ route('dashboard') }}" icon="home" :active="request()->routeIs('dashboard')">Dashboard</x-sidebar-link>
                    <x-sidebar-link href="{{ route('books.index') }}" icon="book-open" :active="request()->routeIs('books.*')">Buku</x-sidebar-link>
                    <x-sidebar-link href="{{ route('members.index') }}" icon="users" :active="request()->routeIs('members.*')">Anggota</x-sidebar-link>
                    <x-sidebar-link href="{{ route('loans.index') }}" icon="arrows-right-left" :active="request()->routeIs('loans.*')" :badge="$activeLoansCount">Peminjaman</x-sidebar-link>
                </div>
            </div>

            <div>
                <div class="mb-1.5 px-2 text-[10px] font-bold uppercase tracking-widest text-muted">FEATURES</div>
                <div class="space-y-1">
                    @if (Route::has('fines.index'))
                        <x-sidebar-link href="{{ route('fines.index') }}" icon="banknotes" :active="request()->routeIs('fines.*')">Denda</x-sidebar-link>
                    @endif
                    @if ($isAdmin && Route::has('categories.index'))
                        <x-sidebar-link href="{{ route('categories.index') }}" icon="tag" :active="request()->routeIs('categories.*')">Kategori</x-sidebar-link>
                    @endif
                    <x-sidebar-link href="{{ route('reports.index') }}" icon="chart-bar" :active="request()->routeIs('reports.*')">Laporan</x-sidebar-link>
                </div>
            </div>

            <div>
                <div class="mb-1.5 px-2 text-[10px] font-bold uppercase tracking-widest text-muted">GENERAL</div>
                <div class="space-y-1">
                    <x-sidebar-link href="{{ route('profile.edit') }}" icon="user-circle" :active="request()->routeIs('profile.*')">Profil</x-sidebar-link>
                    <x-sidebar-link href="#" icon="question-mark-circle">Bantuan</x-sidebar-link>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="sidebar-link w-full text-left text-muted hover:text-ink">
                            <x-heroicon name="arrow-left-on-rectangle" class="h-5 w-5 shrink-0" />
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>


    </aside>
