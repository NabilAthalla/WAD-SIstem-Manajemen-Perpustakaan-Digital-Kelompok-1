<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberModuleTest extends TestCase
{
    use RefreshDatabase;

    private function makeType(array $override = []): MembershipType
    {
        return MembershipType::create($override + [
            'nama' => 'Mahasiswa',
            'kode' => 'MHS',
            'durasi_bulan' => 12,
            'maks_pinjam' => 5,
            'biaya' => 25000,
        ]);
    }

    private function payload(MembershipType $type, array $override = []): array
    {
        return $override + [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'no_telepon' => '081234567890',
            'alamat' => 'Bandung',
            'tanggal_lahir' => '2003-04-12',
            'jenis_kelamin' => 'L',
            'membership_type_id' => $type->id,
            'tanggal_daftar' => '2026-01-10',
            'status' => 'aktif',
        ];
    }

    public function test_module_routes_are_registered(): void
    {
        foreach ([
            'members.index', 'members.create', 'members.store', 'members.show', 'members.edit',
            'members.update', 'members.destroy', 'members.card',
            'membership-types.index', 'membership-types.create', 'membership-types.store',
            'membership-types.edit', 'membership-types.update', 'membership-types.destroy',
            'api.members.index', 'api.members.store', 'api.members.show',
            'api.members.update', 'api.members.destroy',
            'api.membership-types.index', 'api.membership-types.show',
        ] as $name) {
            $this->assertTrue(\Illuminate\Support\Facades\Route::has($name), "Route {$name} tidak ada");
        }
    }

    public function test_member_pages_render(): void
    {
        $type = $this->makeType();
        $member = Member::create($this->payload($type));

        $this->get('/members')->assertOk()->assertSee($member->nomor_kartu);
        $this->get('/members/create')->assertOk();
        $this->get("/members/{$member->id}")->assertOk()->assertSee('Budi Santoso');
        $this->get("/members/{$member->id}/edit")->assertOk();
        $this->get("/members/{$member->id}/card")->assertOk()->assertSee($member->nomor_kartu);
        $this->get('/membership-types')->assertOk();
        $this->get('/membership-types/create')->assertOk();
        $this->get("/membership-types/{$type->id}/edit")->assertOk();
    }

    public function test_can_create_member_with_generated_card_number_and_expiry(): void
    {
        $type = $this->makeType();

        $this->post('/members', $this->payload($type))->assertRedirect();

        $member = Member::first();
        $this->assertNotNull($member);
        $this->assertStringStartsWith('LIB', $member->nomor_kartu);
        $this->assertSame('2027-01-10', $member->tanggal_berlaku->toDateString());
    }

    public function test_create_member_validation_fails(): void
    {

        $this->post('/members', [])->assertSessionHasErrors([
            'nama', 'email', 'jenis_kelamin', 'membership_type_id', 'tanggal_daftar', 'status',
        ]);
        $this->assertSame(0, Member::count());
    }

    public function test_email_must_be_unique(): void
    {
        $type = $this->makeType();
        Member::create($this->payload($type));

        $this->post('/members', $this->payload($type))->assertSessionHasErrors('email');
    }

    public function test_can_update_and_delete_member(): void
    {
        $type = $this->makeType();
        $member = Member::create($this->payload($type));

        $this->put("/members/{$member->id}", $this->payload($type, ['nama' => 'Budi Baru']))
            ->assertRedirect();
        $this->assertDatabaseHas('members', ['id' => $member->id, 'nama' => 'Budi Baru']);

        $this->delete("/members/{$member->id}")->assertRedirect(route('members.index'));
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }

    public function test_search_filters_members(): void
    {
        $type = $this->makeType();
        Member::create($this->payload($type));
        Member::create($this->payload($type, ['nama' => 'Siti Aminah', 'email' => 'siti@example.com']));

        $this->get('/members?search=Siti')
            ->assertOk()
            ->assertSee('Siti Aminah')
            ->assertDontSee('Budi Santoso');
    }

    public function test_membership_type_in_use_cannot_be_deleted(): void
    {
        $type = $this->makeType();
        Member::create($this->payload($type));

        $this->delete("/membership-types/{$type->id}")->assertSessionHas('error');
        $this->assertDatabaseHas('membership_types', ['id' => $type->id]);
    }

    public function test_unused_membership_type_can_be_managed(): void
    {

        $this->post('/membership-types', [
            'nama' => 'Dosen', 'kode' => 'DSN', 'durasi_bulan' => 24, 'maks_pinjam' => 10, 'biaya' => 0,
        ])->assertRedirect(route('membership-types.index'));

        $type = MembershipType::where('kode', 'DSN')->firstOrFail();

        $this->delete("/membership-types/{$type->id}")->assertRedirect(route('membership-types.index'));
        $this->assertDatabaseMissing('membership_types', ['id' => $type->id]);
    }

    public function test_api_member_crud(): void
    {
        $type = $this->makeType();

        $response = $this->postJson('/api/members', $this->payload($type));
        $response->assertCreated()->assertJsonPath('data.nama', 'Budi Santoso');
        $id = $response->json('data.id');

        $this->getJson('/api/members')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson("/api/members/{$id}")->assertOk()->assertJsonPath('data.email', 'budi@example.com');

        $this->putJson("/api/members/{$id}", $this->payload($type, ['nama' => 'Budi Update']))
            ->assertOk()
            ->assertJsonPath('data.nama', 'Budi Update');

        $this->postJson('/api/members', [])->assertUnprocessable();

        $this->deleteJson("/api/members/{$id}")->assertNoContent();
        $this->getJson("/api/members/{$id}")->assertNotFound();
    }

    public function test_api_membership_types_readable(): void
    {
        $type = $this->makeType();

        $this->getJson('/api/membership-types')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson("/api/membership-types/{$type->id}")->assertOk()->assertJsonPath('data.kode', 'MHS');
    }
}
