@props(['name', 'count' => 0, 'href' => '#'])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'card flex items-center justify-between gap-3 p-4 transition hover:-translate-y-0.5']) }}>
    <div>
        <div class="font-semibold text-ink">{{ $name }}</div>
        <div class="text-xs text-muted">{{ $count }} buku</div>
    </div>
    <div class="rounded-xl bg-brand-50 p-2 text-brand">
        <x-heroicon name="tag" class="h-5 w-5" />
    </div>
</a>