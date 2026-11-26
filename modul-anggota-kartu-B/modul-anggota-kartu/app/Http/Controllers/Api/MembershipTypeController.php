<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MembershipTypeResource;
use App\Models\MembershipType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MembershipTypeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return MembershipTypeResource::collection(MembershipType::orderBy('nama')->get());
    }

    public function show(MembershipType $membershipType): MembershipTypeResource
    {
        return new MembershipTypeResource($membershipType);
    }
}
