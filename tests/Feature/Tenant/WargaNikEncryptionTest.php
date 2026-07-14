<?php

namespace Tests\Feature\Tenant;

use Tests\TestCase;
use App\Models\User;
use App\Models\Warga;
use App\Models\Rumah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class WargaNikEncryptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_nik_is_encrypted_in_database()
    {
        $nikPlain = '1234567890123456';
        
        $rumah = Rumah::create(['nomor_blok' => 'A1']);
        $warga = Warga::create([
            'id_rumah' => $rumah->id,
            'nama_lengkap' => 'Test User',
            'nik' => $nikPlain,
            'status_warga' => 'Tetap'
        ]);

        // Assert NIK is accessible decrypted on the model
        $this->assertEquals($nikPlain, $warga->nik);

        // Fetch raw DB row to verify it's encrypted
        $rawWarga = DB::table('warga')->where('id', $warga->id)->first();
        $this->assertNotEquals($nikPlain, $rawWarga->nik);
        $this->assertNotNull($rawWarga->nik_hash);
        
        // nik_hash should be HMAC SHA256 of nikPlain
        $expectedHash = hash_hmac('sha256', $nikPlain, config('app.key'));
        $this->assertEquals($expectedHash, $rawWarga->nik_hash);
    }

    public function test_can_be_viewed_fully_by_role()
    {
        $rumah = Rumah::create(['nomor_blok' => 'A1']);
        $warga = Warga::create([
            'id_rumah' => $rumah->id,
            'nama_lengkap' => 'Warga Test',
            'nik' => '1234567890123456',
            'status_warga' => 'Tetap'
        ]);

        $owner = User::factory()->create();
        Role::firstOrCreate(['name' => 'Tenant Owner']);
        $owner->assignRole('Tenant Owner');

        $bendahara = User::factory()->create();
        Role::firstOrCreate(['name' => 'Bendahara']);
        $bendahara->assignRole('Bendahara');

        $this->assertTrue($warga->canBeViewedFullyBy($owner));
        $this->assertFalse($warga->canBeViewedFullyBy($bendahara));
    }

    public function test_can_be_viewed_fully_by_same_house_member()
    {
        $rumah = Rumah::create(['nomor_blok' => 'A1']);
        $warga1 = Warga::create([
            'id_rumah' => $rumah->id,
            'nama_lengkap' => 'Warga 1',
            'nik' => '1234567890123456',
            'status_warga' => 'Tetap'
        ]);
        
        $warga2 = Warga::create([
            'id_rumah' => $rumah->id,
            'nama_lengkap' => 'Warga 2',
            'nik' => '9876543210987654',
            'status_warga' => 'Tetap'
        ]);

        $user1 = User::factory()->create();
        $warga1->update(['id_user' => $user1->id]);

        $this->assertTrue($warga2->canBeViewedFullyBy($user1));

        // Different house
        $rumah2 = Rumah::create(['nomor_blok' => 'B2']);
        $warga3 = Warga::create([
            'id_rumah' => $rumah2->id,
            'nama_lengkap' => 'Warga 3',
            'nik' => '1111222233334444',
            'status_warga' => 'Tetap'
        ]);
        $this->assertFalse($warga3->canBeViewedFullyBy($user1));
    }
}
