<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ dark: localStorage.getItem('theme') === 'dark' }" x-init="$watch('dark', value => { localStorage.setItem('theme', value ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', value) }); document.documentElement.classList.toggle('dark', dark)">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Perpustakaan') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">
<div x-data="{ open: false }" class="min-h-screen">
    <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 z-30 bg-slate-950/50 lg:hidden"></div>
    @include('layouts.navigation')
    <div class="lg:pl-72">
        <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200/80 bg-white/90 px-4 backdrop-blur dark:border-slate-800 dark:bg-slate-950/90 sm:px-6">
            <button @click="open = !open" class="rounded-lg p-2 text-slate-500 lg:hidden" aria-label="Buka navigasi"><x-heroicon name="bars-3" /></button>
            <div class="hidden text-sm text-slate-500 sm:block">{{ now()->translatedFormat('l, d F Y') }}</div>
            <div class="ml-auto flex items-center gap-3">
                <button @click="dark = !dark" class="rounded-xl border border-slate-200 p-2 text-slate-500 hover:bg-slate-100 dark:border-slate-800 dark:hover:bg-slate-800" aria-label="Toggle dark mode"><span x-show="!dark"><x-heroicon name="moon" /></span><span x-show="dark"><x-heroicon name="sun" /></span></button>
                <div class="hidden text-right sm:block"><div class="text-sm font-semibold">{{ auth()->user()->name }}</div><div class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</div></div>
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            </div>
        </header>
        @if(session('success')) <div class="mx-4 mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300 sm:mx-6">{{ session('success') }}</div> @endif
        <main class="p-4 sm:p-6">{{ $slot }}</main>
    </div>
</div>
</body>
</html>
