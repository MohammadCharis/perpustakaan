@props(['href' => '#', 'active' => false, 'icon' => null, 'badge' => null])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'sidebar-link '.($active ? 'active' : '')]) }}>
    @if($icon)<x-heroicon :name="$icon" class="h-5 w-5 shrink-0" />@endif
    <span class="flex-1">{{ $slot }}</span>
    @if($badge !== null && $badge !== '' && (int) $badge > 0)
        <span class="rounded-full px-2 py-0.5 text-[10px] font-bold {{ $active ? 'bg-white text-brand' : 'bg-brand text-white' }}">{{ $badge }}</span>
    @endif
</a>
