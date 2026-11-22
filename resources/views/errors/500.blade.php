<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Kesalahan Server</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#dfe3ea] text-ink antialiased">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-3xl border border-line bg-white p-10 text-center shadow-xl">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-rose-100 text-rose-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-4h.01M12 12v4"/></svg>
            </div>
            <p class="mt-6 text-xs font-bold uppercase tracking-widest text-muted">HTTP STATUS CODE</p>
            <h1 class="mt-2 text-5xl font-bold tracking-tight text-ink">500</h1>
            <p class="mt-3 text-base font-semibold text-ink">Kesalahan Server</p>
            <p class="mt-2 text-sm text-muted">Terjadi kesalahan pada server. Silakan coba lagi nanti.</p>
            <div class="mt-6 inline-flex w-full items-center justify-between rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-left">
                <div><div class="text-sm font-bold text-rose-800">5xx Server Error</div><div class="text-xs text-rose-700">Server gagal memproses permintaan.</div></div>
                <span class="text-2xl font-bold text-rose-500">5xx</span>
            </div>
            <a href="{{ route('dashboard') }}" class="mt-8 inline-flex w-full items-center justify-center rounded-xl bg-brand px-5 py-3 text-sm font-semibold text-white shadow-[0_8px_16px_rgba(41,121,255,0.35)] transition hover:-translate-y-0.5 hover:bg-brand-dark">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
