<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ open: false }">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}"><title>{{ config('app.name', 'Perpustakaan') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen overflow-hidden bg-[#dfe3ea] text-ink">
<div class="mx-auto h-screen max-w-[1760px] px-0">
    <div class="app-frame" x-data="{ open: false }">
    <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 z-30 bg-ink/40 lg:hidden"></div>
    @include('layouts.navigation')
    <div class="flex h-full min-h-0 flex-1 flex-col">
        @include('layouts.topbar')
        @if(session('success')) <div class="mx-5 mt-5 shrink-0 rounded-xl border border-status-success/30 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 sm:mx-6">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="mx-5 mt-5 shrink-0 rounded-xl border border-status-danger/30 bg-rose-50 px-4 py-3 text-sm text-rose-700 sm:mx-6">{{ session('error') }}</div> @endif
        <main class="min-h-0 flex-1 overflow-y-auto p-5 sm:p-6 lg:p-8">{{ $slot }}</main>
    </div>
    </div>
</div>
</body>
</html>