@props(['status' => 'dipinjam'])
@php($color = match ($status) {
    'dikembalikan' => 'bg-status-success',
    'terlambat' => 'bg-status-danger',
    default => 'bg-status-warning',
})
<span class="inline-block h-2.5 w-2.5 rounded-full {{ $color }}"></span>