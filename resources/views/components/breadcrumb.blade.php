<nav {{ $attributes->merge(['class' => 'hidden items-center gap-1.5 rounded-xl bg-canvas px-3 py-1.5 text-sm sm:flex']) }}>
    @foreach ($items as $item)
        @if (! $loop->first)
            <x-heroicon name="chevron-right" class="h-3.5 w-3.5 text-muted" />
        @endif
        @if ($item['url'])
            <a href="{{ $item['url'] }}" class="font-medium text-muted transition hover:text-ink">{{ $item['label'] }}</a>
        @else
            <span class="font-semibold text-ink">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>