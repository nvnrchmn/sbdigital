<?php

namespace Tests\Feature\Superadmin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SuperadminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function createSuperAdmin()
    {
        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('Super Admin');
        return $user;
    }

    public function test_superadmin_can_access_dashboard(): void
    {
        $superadmin = $this->createSuperAdmin();

        $response = $this->actingAs($superadmin)->get('/superadmin/dashboard');

        $response->assertStatus(200);
        $response->assertSeeLivewire(\App\Livewire\Central\Dashboard\Index::class);
    }

    public function test_non_superadmin_cannot_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/superadmin/dashboard');

        // Middleware should block and return 403 or redirect
        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/superadmin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_renders_livewire_component_correctly(): void
    {
        $superadmin = $this->createSuperAdmin();

        Livewire::actingAs($superadmin)
            ->test(\App\Livewire\Central\Dashboard\Index::class)
            ->assertStatus(200);
    }
}
