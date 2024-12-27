<?php

namespace Tests\Unit\Device;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Device;
use App\Models\User;
use App\Http\Controllers\DeviceController;

class AdminDeviceUnitTest extends TestCase
{
    use RefreshDatabase;

    protected $deviceController;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deviceController = new DeviceController();
        // Check for the availability of the tester account
        $tester = User::where('email', 'admin@finbites.com')->first();
        // Create user for testing
        if ($tester == null) {
            // Create user with specific email for testing
            $this->user = User::factory()->create([
                'name' => 'Tester',
                'email' => 'admin@finbites.com',
            ]);
        } else {
            $this->user = $tester;
        }
        $this->actingAs($this->user); // Authenticate the user
    }

    public function test_gagal_menambahkan_perangkat_tanpa_data_pengguna()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'name' => 'Device 1',
            'topic' => 'device/topic',
            'capacity' => 5,
        ]);

        $response->assertSessionHasErrors('user_id');
        $this->assertEquals('Pengguna tidak boleh kosong.', session('errors')->get('user_id')[0]);
    }

    public function test_gagal_menambahkan_perangkat_tanpa_data_nama()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'topic' => 'device/topic',
            'capacity' => 5,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama tidak boleh kosong.', session('errors')->get('name')[0]);
    }

    public function test_gagal_menambahkan_perangkat_with_nama_kurang_dari_3_karakter()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'De',
            'topic' => 'device/topic',
            'capacity' => 5,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama minimal 3 karakter.', session('errors')->get('name')[0]);
    }

    public function test_gagal_menambahkan_perangkat_with_nama_lebih_dari_30_karakter()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => str_repeat('A', 31),
            'topic' => 'device/topic',
            'capacity' => 5,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama maksimal 30 karakter.', session('errors')->get('name')[0]);
    }

    public function test_gagal_menambahkan_perangkat_tanpa_topic()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Device 1',
            'capacity' => 5,
        ]);

        $response->assertSessionHasErrors('topic');
        $this->assertEquals('Topik tidak boleh kosong.', session('errors')->get('topic')[0]);
    }

    public function test_gagal_menambahkan_perangkat_with_duplicate_topic()
    {
        Device::factory()->create(['topic' => 'device/topic', 'user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Device 2',
            'topic' => 'device/topic',
            'capacity' => 5,
        ]);

        $response->assertSessionHasErrors('topic');
        $this->assertEquals('Topik yang diinputkan sudah terpakai.', session('errors')->get('topic')[0]);
    }

    public function test_gagal_menambahkan_perangkat_tanpa_capacity()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Device 1',
            'topic' => 'device/topic',
        ]);

        $response->assertSessionHasErrors('capacity');
        $this->assertEquals('Kapasitas tidak boleh kosong.', session('errors')->get('capacity')[0]);
    }

    public function test_gagal_menambahkan_perangkat_with_kapasitas_kurang_dari_2()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Device 1',
            'topic' => 'device/topic',
            'capacity' => 1,
        ]);

        $response->assertSessionHasErrors('capacity');
        $this->assertEquals('Kapasitas minimal 2.', session('errors')->get('capacity')[0]);
    }

    public function test_gagal_menambahkan_perangkat_with_kapasitas_lebih_dari_12()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Device 1',
            'topic' => 'device/topic',
            'capacity' => 13,
        ]);

        $response->assertSessionHasErrors('capacity');
        $this->assertEquals('Kapasitas maksimal 12.', session('errors')->get('capacity')[0]);
    }

    public function test_berhasil_menambahkan_perangkat_dengan_data_valid()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Device 1',
            'topic' => 'device/topic',
            'capacity' => 5,
        ]);

        $response->assertRedirect(route('devices.index'));
        $response->assertSessionHas('toast_success', 'Data Device 1 berhasil ditambahkan');
    }

    public function test_gagal_mengubah_perangkat_tanpa_data_pengguna()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'name' => 'Device 1',
            'topic' => 'device/topic',
            'capacity' => 5,
        ]);

        $response->assertSessionHasErrors('user_id');
        $this->assertEquals('Pengguna tidak boleh kosong.', session('errors')->get('user_id')[0]);
    }

    public function test_gagal_mengubah_perangkat_tanpa_data_nama()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'topic' => 'device/topic',
            'capacity' => 5,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama tidak boleh kosong.', session('errors')->get('name')[0]);
    }

    public function test_berhasil_mengubah_perangkat_dengan_data_valid()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'name' => 'Device Updated',
            'topic' => 'device/topic/updated',
            'capacity' => 5,
        ]);

        $response->assertRedirect(route('devices.index'));
        $response->assertSessionHas('toast_success', 'Data Device Updated berhasil diubah');
    }

    public function test_berhasil_menghapus_perangkat()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->delete("/devices/admin/{$device->id}/delete");

        $response->assertRedirect(route('devices.index'));
        $response->assertSessionHas('toast_success', "Data $device->name berhasil berhasil dihapus");
    }
}