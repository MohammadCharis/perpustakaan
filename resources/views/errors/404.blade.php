<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#dfe3ea] text-ink antialiased">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-3xl border border-line bg-white p-10 text-center shadow-xl">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/></svg>
            </div>
            <p class="mt-6 text-xs font-bold uppercase tracking-widest text-muted">HTTP STATUS CODE</p>
            <h1 class="mt-2 text-5xl font-bold tracking-tight text-ink">404</h1>
            <p class="mt-3 text-base font-semibold text-ink">Halaman Tidak Ditemukan</p>
            <p class="mt-2 text-sm text-muted">Halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
            <div class="mt-6 inline-flex w-full items-center justify-between rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-left">
                <div><div class="text-sm font-bold text-amber-800">4xx Client Error</div><div class="text-xs text-amber-700">Permintaan tidak dapat diproses.</div></div>
                <span class="text-2xl font-bold text-amber-500">4xx</span>
            </div>
            <a href="{{ route('dashboard') }}" class="mt-8 inline-flex w-full items-center justify-center rounded-xl bg-brand px-5 py-3 text-sm font-semibold text-white shadow-[0_8px_16px_rgba(41,121,255,0.35)] transition hover:-translate-y-0.5 hover:bg-brand-dark">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
