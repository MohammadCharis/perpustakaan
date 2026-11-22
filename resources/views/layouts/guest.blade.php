<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ infoOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Perpustakaan') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-login-bg text-login-title antialiased dark:bg-login-bg">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-login-bg p-4 sm:p-8">
        <div class="pointer-events-none absolute -right-24 top-1/4 h-72 w-72 rounded-[3rem] bg-login-shape/70 blur-2xl dark:bg-login-shape/40" aria-hidden="true"></div>
        <div class="relative grid min-h-[460px] w-full max-w-[860px] overflow-hidden rounded-3xl bg-login-surface shadow-[0_24px_70px_rgba(15,23,42,0.14)] lg:grid-cols-2">
            <section class="relative flex flex-col justify-center overflow-hidden bg-login-blue px-7 py-8 text-white sm:px-10 lg:px-10">
                <div class="relative z-10 max-w-sm">
                    <img src="{{ asset('logo.png') }}" alt="Logo Perpustakaan" class="mb-8 h-14 w-14 rounded-2xl bg-white object-contain p-1">
                    <h1 class="text-3xl font-bold leading-tight sm:text-4xl">Selamat Datang di Perpustakaan</h1>
                    <div class="mt-5 h-1 w-14 rounded-full bg-white"></div>
                    <p class="mt-6 text-sm leading-7 text-white lg:text-base">Kelola koleksi buku, anggota, dan peminjaman dalam satu tempat.</p>
                    <button type="button" @click="infoOpen = true" class="mt-8 rounded-full border border-white px-6 py-3 text-sm font-semibold transition hover:bg-white hover:text-login-blue focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-login-blue lg:inline-flex">Pelajari Lebih Lanjut</button>
                </div>
                <div class="pointer-events-none absolute -right-20 top-1/2 hidden h-64 w-64 -translate-y-1/2 rounded-full border-[22px] border-white/90 lg:block" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -right-6 top-1/2 hidden h-44 w-44 -translate-y-1/2 rounded-full border-[14px] border-white/50 lg:block" aria-hidden="true"></div>
            </section>
            <section class="relative flex items-center justify-center bg-login-surface px-6 py-8 sm:px-10 sm:px-14">
                <div class="pointer-events-none absolute -right-20 bottom-10 h-44 w-44 rotate-12 rounded-[2rem] bg-login-shape dark:bg-login-shape" aria-hidden="true"></div>
                <div class="relative z-10 w-full max-w-sm">
                    {{ $slot }}
                </div>
            </section>
        </div>
    </div>
    <div x-show="infoOpen" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-login-title/40 p-4" @keydown.escape.window="infoOpen = false" @click.self="infoOpen = false">
        <div class="w-full max-w-md rounded-2xl bg-login-surface p-6 shadow-xl" role="dialog" aria-modal="true" aria-labelledby="info-title">
            <h2 id="info-title" class="text-lg font-bold">Tentang Perpustakaan</h2>
            <p class="mt-3 text-sm leading-6 text-login-title">Sistem ini membantu petugas mengatur koleksi buku, anggota, peminjaman, pengembalian, dan laporan secara terpusat.</p>
            <button type="button" @click="infoOpen = false" class="mt-5 rounded-xl bg-login-blue px-4 py-2 text-sm font-semibold text-white hover:bg-login-blue">Tutup</button>
        </div>
    </div>
</body>
</html>
