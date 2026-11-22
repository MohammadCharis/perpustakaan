<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Member::class);

        return view('members.index', ['members' => Member::withCount('loans')->latest()->paginate(15)]);
    }

    public function create(): View
    {
        $this->authorize('create', Member::class);

        return view('members.form');
    }

    public function store(StoreMemberRequest $request): RedirectResponse
    {
        $this->authorize('create', Member::class);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        Member::create($data);

        return to_route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member): View
    {
        $this->authorize('update', $member);

        return view('members.form', compact('member'));
    }

    public function update(StoreMemberRequest $request, Member $member): RedirectResponse
    {
        $this->authorize('update', $member);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $member->update($data);

        return to_route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $this->authorize('delete', $member);

        if ($member->loans()->whereNull('returned_at')->exists()) {
            return back()->with('error', 'Anggota masih memiliki peminjaman aktif.');
        }

        try {
            $member->delete();
        } catch (QueryException) {
            return back()->with('error', 'Anggota tidak dapat dihapus karena masih memiliki riwayat peminjaman.');
        }

        return to_route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
