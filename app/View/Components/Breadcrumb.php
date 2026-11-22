<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Breadcrumb extends Component
{
    public array $items;

    public function __construct()
    {
        $routeName = request()->route()?->getName();
        $map = [
            'dashboard' => 'Dashboard',
            'books.index' => 'Buku',
            'books.create' => 'Tambah Buku',
            'books.edit' => 'Ubah Buku',
            'members.index' => 'Anggota',
            'members.create' => 'Tambah Anggota',
            'members.edit' => 'Ubah Anggota',
            'loans.index' => 'Peminjaman',
            'loans.create' => 'Tambah Peminjaman',
            'fines.index' => 'Denda',
            'categories.index' => 'Kategori',
            'categories.create' => 'Tambah Kategori',
            'categories.edit' => 'Ubah Kategori',
            'reports.index' => 'Laporan',
            'profile.edit' => 'Profil',
        ];

        $items = [];
        if ($routeName === 'dashboard') {
            $items[] = ['label' => 'Perpustakaan', 'url' => route('dashboard')];
            $items[] = ['label' => 'Dashboard', 'url' => null];
        } else {
            $items[] = ['label' => 'Perpustakaan', 'url' => route('dashboard')];
            $items[] = ['label' => $map[$routeName] ?? ucfirst(str_replace(['.', '-'], ' ', (string) $routeName)), 'url' => null];
        }

        $this->items = $items;
    }

    public function render(): View
    {
        return view('components.breadcrumb');
    }
}
