@props(['href' => '#', 'active' => false, 'icon' => null])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'sidebar-link '.($active ? 'active' : '')]) }}>
    @if($icon)<x-heroicon :name="$icon" class="h-5 w-5 shrink-0" />@endif
    <span>{{ $slot }}</span>
</a>
