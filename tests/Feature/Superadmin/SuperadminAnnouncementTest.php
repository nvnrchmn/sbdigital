<?php

namespace Tests\Feature\Superadmin;

use App\Models\GlobalAnnouncement;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SuperadminAnnouncementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['tenancy.database.central_connection' => 'sqlite']);
    }

    protected function createSuperAdmin()
    {
        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole('Super Admin');
        return $user;
    }

    public function test_superadmin_can_view_announcements_list(): void
    {
        $superadmin = $this->createSuperAdmin();

        $response = $this->actingAs($superadmin)->get('/superadmin/announcements');

        $response->assertStatus(200);
        $response->assertSeeLivewire(\App\Livewire\Central\Announcement\Index::class);
    }

    public function test_superadmin_can_create_announcement(): void
    {
        $superadmin = $this->createSuperAdmin();

        Livewire::actingAs($superadmin)
            ->test(\App\Livewire\Central\Announcement\Form::class)
            ->set('title', 'System Maintenance')
            ->set('content', 'System will be down for 2 hours.')
            ->set('is_active', true)
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('superadmin.announcements.index'));

        $this->assertDatabaseHas('global_announcements', [
            'title' => 'System Maintenance',
            'is_active' => 1,
        ]);
    }

    public function test_superadmin_can_update_announcement(): void
    {
        $superadmin = $this->createSuperAdmin();
        $announcement = GlobalAnnouncement::create([
            'title' => 'Old Info',
            'content' => 'Old content',
            'is_active' => false,
        ]);

        Livewire::actingAs($superadmin)
            ->test(\App\Livewire\Central\Announcement\Form::class, ['announcement' => $announcement])
            ->set('title', 'Updated Info')
            ->set('is_active', true)
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('superadmin.announcements.index'));

        $this->assertDatabaseHas('global_announcements', [
            'id' => $announcement->id,
            'title' => 'Updated Info',
            'is_active' => 1,
        ]);
    }
}
