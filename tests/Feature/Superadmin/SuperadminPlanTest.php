<?php

namespace Tests\Feature\Superadmin;

use App\Models\Plan;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SuperadminPlanTest extends TestCase
{
    use RefreshDatabase;

    protected function createSuperAdmin()
    {
        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('Super Admin');
        return $user;
    }

    public function test_superadmin_can_view_plans_list(): void
    {
        $superadmin = $this->createSuperAdmin();

        $response = $this->actingAs($superadmin)->get('/superadmin/plans');

        $response->assertStatus(200);
        $response->assertSeeLivewire(\App\Livewire\Central\Plan\Index::class);
    }

    public function test_superadmin_can_create_plan(): void
    {
        $superadmin = $this->createSuperAdmin();

        Livewire::actingAs($superadmin)
            ->test(\App\Livewire\Central\Plan\Form::class)
            ->set('name', 'Test Plan')
            ->set('max_houses', 100)
            ->set('features', ['warga', 'iuran'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('superadmin.plans.index'));

        $this->assertDatabaseHas('plans', [
            'name' => 'Test Plan',
            'max_houses' => 100,
        ]);
    }

    public function test_superadmin_can_update_plan(): void
    {
        $superadmin = $this->createSuperAdmin();
        $plan = Plan::create([
            'name' => 'Old Plan',
            'max_houses' => 50,
            'features' => [],
        ]);

        Livewire::actingAs($superadmin)
            ->test(\App\Livewire\Central\Plan\Form::class, ['plan' => $plan])
            ->set('name', 'Updated Plan')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('superadmin.plans.index'));

        $this->assertDatabaseHas('plans', [
            'id' => $plan->id,
            'name' => 'Updated Plan',
        ]);
    }
}
