<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use App\Models\MembershipType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $members = Member::with('membershipType')
            ->cari($request->only(['search', 'status', 'membership_type_id']))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('members.index', [
            'members' => $members,
            'types' => MembershipType::orderBy('nama')->get(),
        ]);
    }

    public function create(): View
    {
        return view('members.create', [
            'member' => new Member([
                'status' => 'aktif',
                'tanggal_daftar' => now(),
            ]),
            'types' => MembershipType::orderBy('nama')->get(),
        ]);
    }

    public function store(MemberRequest $request): RedirectResponse
    {
        $member = Member::create($request->validated());

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(Member $member): View
    {
        $member->load('membershipType');

        return view('members.show', ['member' => $member]);
    }

    public function edit(Member $member): View
    {
        return view('members.edit', [
            'member' => $member,
            'types' => MembershipType::orderBy('nama')->get(),
        ]);
    }

    public function update(MemberRequest $request, Member $member): RedirectResponse
    {
        $member->update($request->validated());

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }

    public function card(Member $member): View
    {
        $member->load('membershipType');

        return view('members.card', ['member' => $member]);
    }
}
