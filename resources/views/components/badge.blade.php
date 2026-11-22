@props(['variant' => 'default'])
@php($classes = ['default' => 'bg-slate-100 text-slate-800', 'success' => 'bg-emerald-500 text-white', 'warning' => 'bg-amber-500 text-white', 'danger' => 'bg-rose-500 text-white', 'info' => 'bg-indigo-500 text-white'][$variant] ?? '')
<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {$classes}"]) }}>{{ $slot }}</span>
