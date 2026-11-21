@props(['title', 'subtitle' => null, 'href' => '#', 'active' => false, 'icon' => 'folder'])
<a href="{{ $href }}" class="folder-card relative block min-w-[220px] rounded-2xl p-5 transition hover:-translate-y-0.5 {{ $active ? 'bg-blue-600 text-white' : 'bg-[#edf3fc] text-slate-800' }}">
    <span class="folder-tab"></span>
    <div class="relative z-10 flex h-full min-h-28 flex-col justify-between">
        <x-heroicon :name="$icon" class="h-6 w-6 {{ $active ? 'text-white' : 'text-blue-600' }}" />
        <div><div class="mt-5 font-semibold">{{ $title }}</div>@if($subtitle)<div class="mt-1 text-xs {{ $active ? 'text-blue-100' : 'text-slate-500' }}">{{ $subtitle }}</div>@endif</div>
    </div>
</a>
