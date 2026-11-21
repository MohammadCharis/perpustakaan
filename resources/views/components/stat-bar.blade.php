@props(['label', 'value', 'total'])
@php($percent = $total > 0 ? min(100, round(($value / $total) * 100)) : 0)
<div><div class="mb-1 flex justify-between gap-3 text-xs text-blue-100"><span>{{ $label }}</span><span>{{ $value }} dari {{ $total }}</span></div><div class="h-1.5 overflow-hidden rounded-full bg-blue-400/40"><div class="h-full rounded-full bg-white" style="width: {{ $percent }}%"></div></div></div>
