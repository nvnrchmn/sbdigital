<?php

namespace Tests\Feature\Superadmin;

use App\Models\Tenant;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SuperadminTenantTest extends TestCase
{
    use RefreshDatabase;

    protected function createSuperAdmin()
    {
        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('Super Admin');
        return $user;
    }

    public function test_superadmin_can_view_tenants_list(): void
    {
        $superadmin = $this->createSuperAdmin();

        $response = $this->actingAs($superadmin)->get('/superadmin/tenants');

        $response->assertStatus(200);
        $response->assertSeeLivewire(\App\Livewire\Central\Tenant\Index::class);
    }

    public function test_non_superadmin_cannot_access_tenants_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/superadmin/tenants');

        $response->assertStatus(403);
    }
}
