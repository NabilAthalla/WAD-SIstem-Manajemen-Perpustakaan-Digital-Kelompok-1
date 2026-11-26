<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $members = Member::with('membershipType')
            ->cari($request->only(['search', 'status', 'membership_type_id']))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return MemberResource::collection($members);
    }

    public function store(MemberRequest $request): JsonResponse
    {
        $member = Member::create($request->validated())->load('membershipType');

        return (new MemberResource($member))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Member $member): MemberResource
    {
        return new MemberResource($member->load('membershipType'));
    }

    public function update(MemberRequest $request, Member $member): MemberResource
    {
        $member->update($request->validated());

        return new MemberResource($member->load('membershipType'));
    }

    public function destroy(Member $member): Response
    {
        $member->delete();

        return response()->noContent();
    }
}
