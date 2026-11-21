@props(['name', 'size' => 'md'])
@php($colors = ['bg-blue-100 text-blue-700', 'bg-violet-100 text-violet-700', 'bg-amber-100 text-amber-700', 'bg-emerald-100 text-emerald-700'])
@php($color = $colors[abs(crc32($name)) % count($colors)])
<div {{ $attributes->merge(['class' => 'flex items-center justify-center rounded-full font-bold '.$color.' '.($size === 'sm' ? 'h-7 w-7 text-[10px]' : 'h-10 w-10 text-sm')]) }} aria-label="{{ $name }}">{{ strtoupper(substr($name, 0, 1)) }}</div>
