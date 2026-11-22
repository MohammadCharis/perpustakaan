@props(['icon' => 'bell', 'label' => null])
<button type="button" {{ $attributes->merge(['class' => 'inline-flex h-9 w-9 items-center justify-center rounded-xl border border-line bg-surface text-muted transition hover:bg-canvas hover:text-ink']) }} aria-label="{{ $label }}">
    <x-heroicon :name="$icon" class="h-5 w-5" />
</button>