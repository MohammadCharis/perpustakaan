<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        return view('members.index', ['members' => Member::withCount('loans')->latest()->paginate(15)]);
    }

    public function create(): View
    {
        return view('members.form');
    }

    public function store(StoreMemberRequest $request): RedirectResponse
    {
        Member::create($request->validated());

        return to_route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member): View
    {
        return view('members.form', compact('member'));
    }

    public function update(StoreMemberRequest $request, Member $member): RedirectResponse
    {
        $member->update($request->validated());

        return to_route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        if ($member->loans()->whereNull('returned_at')->exists()) {
            return back()->with('error', 'Anggota masih memiliki peminjaman aktif.');
        } $member->delete();

        return to_route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
