@props(['title' => null, 'description' => null])
<section {{ $attributes->merge(['class' => 'card']) }}>
    @if($title || $description || isset($actions))
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
            <div>@if($title)<h2 class="font-semibold text-slate-900 dark:text-white">{{ $title }}</h2>@endif @if($description)<p class="mt-1 text-sm text-slate-500">{{ $description }}</p>@endif</div>
            @isset($actions)<div>{{ $actions }}</div>@endisset
        </div>
    @endif
    <div class="p-5">{{ $slot }}</div>
</section>
