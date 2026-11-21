<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ open: false }">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}"><title>{{ config('app.name', 'Perpustakaan') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="app-frame" x-data="{ open: false }">
    <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 z-30 bg-slate-950/50 lg:hidden"></div>
    @include('layouts.navigation')
    <div class="min-h-screen lg:ml-72">
        <header class="flex h-20 items-center gap-4 border-b border-slate-100 bg-white px-5 sm:px-8">
            <button @click="open = !open" class="rounded-lg p-2 text-slate-500 lg:hidden" aria-label="Buka navigasi"><x-heroicon name="bars-3" /></button>
            <div class="relative hidden max-w-md flex-1 sm:block"><x-heroicon name="magnifying-glass" class="absolute left-3 top-2.5 h-5 w-5 text-slate-400" /><input class="input pl-10" placeholder="Search books, members..." /></div>
            <div class="ml-auto flex items-center gap-3"><button class="rounded-xl p-2 text-slate-400 hover:bg-slate-50" aria-label="Notifications"><x-heroicon name="bell" /></button><div class="hidden text-right sm:block"><div class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</div><div class="text-xs capitalize text-slate-400">{{ auth()->user()->role }}</div></div><div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div></div>
        </header>
        @if(session('success')) <div class="mx-5 mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 sm:mx-8">{{ session('success') }}</div> @endif
        <main class="p-5 sm:p-8">{{ $slot }}</main>
    </div>
</div>
</body>
</html>