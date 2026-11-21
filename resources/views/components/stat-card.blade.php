@props(['value', 'label', 'icon' => 'chart-bar', 'tone' => 'indigo'])
<div class="card p-5">
    <div class="flex items-start justify-between gap-4"><div><p class="text-sm font-medium text-slate-500">{{ $label }}</p><p class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $value }}</p></div><div class="rounded-xl bg-{{ $tone }}-50 p-3 text-{{ $tone }}-600 dark:bg-{{ $tone }}-500/10 dark:text-{{ $tone }}-300"><x-heroicon :name="$icon" /></div></div>
</div>
