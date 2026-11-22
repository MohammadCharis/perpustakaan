@props(['value', 'label', 'icon' => 'chart-bar', 'tone' => 'brand'])
@php($isGreen = $tone === 'green')
<div class="card p-5 {{ $isGreen ? 'border-0 bg-brand text-white' : '' }}">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-medium {{ $isGreen ? 'text-white/80' : 'text-muted' }}">{{ $label }}</p>
            <p class="mt-2 text-2xl font-bold tracking-tight {{ $isGreen ? 'text-white' : 'text-ink' }}">{{ $value }}</p>
        </div>
        <div class="mt-4 text-xs {{ $isGreen ? 'text-white/70' : 'text-muted' }}">Lihat detail →</div>
        <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $isGreen ? 'bg-white/20 text-white' : ($tone === 'brand' ? 'bg-brand-50 text-brand' : ($tone === 'amber' ? 'bg-amber-50 text-amber-600' : 'bg-rose-50 text-rose-600')) }}">
            <x-heroicon :name="$icon" class="h-5 w-5" />
        </div>
    </div>
</div>