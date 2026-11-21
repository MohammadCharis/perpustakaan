<aside x-show="open || window.innerWidth >= 1024" x-transition class="fixed inset-y-0 left-0 z-40 flex w-72 flex-col border-r border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900 lg:translate-x-0" x-cloak>
    <div class="flex h-16 items-center gap-3 border-b border-slate-100 px-6 dark:border-slate-800"><img src="{{ asset('logo.png') }}" alt="Logo Perpustakaan" class="h-10 w-10 rounded-xl object-contain"><div><div class="font-bold tracking-tight">Perpustakaan</div><div class="text-xs text-slate-500">Library workspace</div></div></div>
    <nav class="flex-1 space-y-1 p-4 text-sm font-medium">
        <div class="mb-3 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">Workspace</div>
        @foreach([['dashboard','Dashboard','home'],['books.index','Buku','book-open'],['loans.index','Peminjaman','arrows-right-left'],['reports.index','Laporan','chart-bar']] as $item)
            <a href="{{ route($item[0]) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs($item[0]) ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800' }}"><x-heroicon :name="$item[2]" class="h-5 w-5" />{{ $item[1] }}</a>
        @endforeach
        @if(auth()->user()->isAdmin())
            <div class="mb-3 mt-7 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">Management</div>
            @foreach([['members.index','Anggota','users'],['categories.index','Kategori','tag']] as $item)
                <a href="{{ route($item[0]) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs($item[0]) ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800' }}"><x-heroicon :name="$item[2]" class="h-5 w-5" />{{ $item[1] }}</a>
            @endforeach
        @endif
    </nav>
    <div class="border-t border-slate-100 p-4 dark:border-slate-800"><a href="{{ route('profile.edit') }}" class="mb-2 block rounded-xl px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 dark:text-slate-300">Pengaturan profil</a><form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full rounded-xl px-3 py-2 text-left text-sm font-medium text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30">Keluar</button></form></div>
</aside>
