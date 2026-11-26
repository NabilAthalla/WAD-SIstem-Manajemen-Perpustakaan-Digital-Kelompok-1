<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipTypeRequest;
use App\Models\MembershipType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MembershipTypeController extends Controller
{
    public function index(): View
    {
        return view('membership-types.index', [
            'types' => MembershipType::withCount('members')->orderBy('nama')->get(),
        ]);
    }

    public function create(): View
    {
        return view('membership-types.create', ['type' => new MembershipType()]);
    }

    public function store(MembershipTypeRequest $request): RedirectResponse
    {
        MembershipType::create($request->validated());

        return redirect()
            ->route('membership-types.index')
            ->with('success', 'Tipe keanggotaan berhasil ditambahkan.');
    }

    public function edit(MembershipType $membershipType): View
    {
        return view('membership-types.edit', ['type' => $membershipType]);
    }

    public function update(MembershipTypeRequest $request, MembershipType $membershipType): RedirectResponse
    {
        $membershipType->update($request->validated());

        return redirect()
            ->route('membership-types.index')
            ->with('success', 'Tipe keanggotaan berhasil diperbarui.');
    }

    public function destroy(MembershipType $membershipType): RedirectResponse
    {
        if ($membershipType->members()->exists()) {
            return redirect()
                ->route('membership-types.index')
                ->with('error', 'Tipe tidak bisa dihapus karena masih dipakai oleh anggota.');
        }

        $membershipType->delete();

        return redirect()
            ->route('membership-types.index')
            ->with('success', 'Tipe keanggotaan berhasil dihapus.');
    }
}
