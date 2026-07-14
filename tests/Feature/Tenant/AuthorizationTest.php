<?php

namespace Tests\Feature\Tenant;

use Tests\TestCase;
use App\Models\User;
use App\Models\Warga;
use App\Models\Rumah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Livewire\Livewire;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_warga_biasa_cannot_access_role_form()
    {
        $wargaUser = User::factory()->create();
        
        Livewire::actingAs($wargaUser)
            ->test(\App\Livewire\Tenant\Role\Form::class)
            ->assertForbidden();
    }

    public function test_warga_biasa_cannot_access_rumah_form()
    {
        $wargaUser = User::factory()->create();
        
        Livewire::actingAs($wargaUser)
            ->test(\App\Livewire\Tenant\Rumah\Form::class)
            ->assertForbidden();
    }
    
    public function test_warga_biasa_cannot_access_pengumuman_form()
    {
        $wargaUser = User::factory()->create();
        
        Livewire::actingAs($wargaUser)
            ->test(\App\Livewire\Tenant\Pengumuman\Form::class)
            ->assertForbidden();
    }

    public function test_tenant_owner_can_access_role_form()
    {
        $owner = User::factory()->create();
        Role::firstOrCreate(['name' => 'Tenant Owner']);
        $owner->assignRole('Tenant Owner');
        
        Livewire::actingAs($owner)
            ->test(\App\Livewire\Tenant\Role\Form::class)
            ->assertStatus(200);
    }
}
