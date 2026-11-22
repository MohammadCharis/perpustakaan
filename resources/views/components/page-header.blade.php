@props(['title', 'description' => null])
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-ink sm:text-3xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-muted">{{ $description }}</p>
        @endif
    </div>
    <div class="shrink-0">{{ $slot }}</div>
</div>
