<?php

namespace Tests\Unit\Device;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Device;
use App\Models\User;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Log;

class AdminDeviceUnitTest extends TestCase
{
    use RefreshDatabase;

    protected $deviceController;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deviceController = new DeviceController();
        // Periksa ketersediaan akun tester
        $tester = User::where('email', 'admin@finbites.com')->first();
        // Membuat pengguna dan perangkat untuk pengujian
        if ($tester == null) {
            // Membuat pengguna dengan email khusus tester
            $this->user = User::factory()->create([
                'name' => 'Tester',
                'email' => 'admin@finbites.com',
            ]);
        } else {
            $this->user = $tester;
        }
        $this->actingAs($this->user); // Authenticate the user
        $this->startSession(); // Ensure the session is started
    }

    // public function test_gagal_menambahkan_perangkat_tanpa_data_pengguna()
    // {
    //     $response = $this->withoutMiddleware()->post('/devices/admin', [
    //         'name' => 'Kolam 03',
    //         'topic' => 'finbites/test3',
    //         'capacity' => 12,
    //     ]);

    //     $response->assertSessionHasErrors('user_id');
    //     $this->assertEquals('Pengguna tidak boleh kosong.', session('errors')->get('user_id')[0]);
    // }

    public function test_gagal_menambahkan_perangkat_tanpa_data_nama()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'topic' => 'finbites/test3',
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama tidak boleh kosong.', session('errors')->get('name')[0]);
    }

    public function test_gagal_menambahkan_perangkat_dengan_nama_kurang_dari_3_karakter()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'K3',
            'topic' => 'finbites/test3',
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama minimal 3 karakter.', session('errors')->get('name')[0]);
    }

    public function test_gagal_menambahkan_perangkat_dengan_nama_lebih_dari_30_karakter()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            // 'name' => str_repeat('A', 31),
            'name' => 'Ada Ikan lele di dalam kolam 002',
            'topic' => 'finbites/test3',
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama maksimal 30 karakter.', session('errors')->get('name')[0]);
    }

    public function test_gagal_menambahkan_perangkat_tanpa_topic()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('topic');
        $this->assertEquals('Topik tidak boleh kosong.', session('errors')->get('topic')[0]);
    }

    public function test_gagal_menambahkan_perangkat_dengan_duplicate_topic()
    {
        Device::factory()->create(['name' => 'Kolam 01', 'topic' => 'finbites/test1', 'user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'topic' => 'finbites/test1',
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('topic');
        $this->assertEquals('Topik yang diinputkan sudah terpakai.', session('errors')->get('topic')[0]);
    }

    public function test_gagal_menambahkan_perangkat_tanpa_kapasitas()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'topic' => 'finbites/test3',
        ]);

        $response->assertSessionHasErrors('capacity');
        $this->assertEquals('Kapasitas tidak boleh kosong.', session('errors')->get('capacity')[0]);
    }

    public function test_gagal_menambahkan_perangkat_dengan_kapasitas_kurang_dari_2()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'topic' => 'finbites/test3',
            'capacity' => 1,
        ]);

        $response->assertSessionHasErrors('capacity');
        $this->assertEquals('Kapasitas minimal 2.', session('errors')->get('capacity')[0]);
    }

    public function test_gagal_menambahkan_perangkat_dengan_kapasitas_lebih_dari_12()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'topic' => 'finbites/test3',
            'capacity' => 15,
        ]);

        $response->assertSessionHasErrors('capacity');
        $this->assertEquals('Kapasitas maksimal 12.', session('errors')->get('capacity')[0]);
    }

    public function test_berhasil_menambahkan_perangkat_dengan_data_valid()
    {
        $response = $this->withoutMiddleware()->post('/devices/admin', [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'topic' => 'finbites/test3',
            'capacity' => 12,
        ]);

        $response->assertRedirect(route('devices.index'));
        $response->assertSessionHas('toast_success', 'Data Kolam 03 berhasil ditambahkan');
    }

    // public function test_gagal_mengubah_perangkat_tanpa_data_pengguna()
    // {
    //     $device = Device::factory()->create(['user_id' => $this->user->id]);

    //     $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
    //         'name' => 'Kolam 03',
    //         'topic' => 'finbites/test3',
    //         'capacity' => 12,
    //     ]);

    //     $response->assertSessionHasErrors('user_id');
    //     $this->assertEquals('Pengguna tidak boleh kosong.', session('errors')->get('user_id')[0]);
    // }

    public function test_gagal_mengubah_perangkat_tanpa_data_nama()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'topic' => 'finbites/test3',
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama tidak boleh kosong.', session('errors')->get('name')[0]);
    }

    public function test_gagal_mengubah_perangkat_dengan_nama_kurang_dari_3_karakter()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'name' => 'K3',
            'topic' => 'finbites/test3',
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama minimal 3 karakter.', session('errors')->get('name')[0]);
    }

    public function test_gagal_mengubah_perangkat_dengan_nama_lebih_dari_30_karakter()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            // 'name' => str_repeat('A', 31),
            'name' => 'Ada Ikan lele di dalam kolam 002',
            'topic' => 'finbites/test3',
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Nama maksimal 30 karakter.', session('errors')->get('name')[0]);
    }

    public function test_gagal_mengubah_perangkat_tanpa_topic()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('topic');
        $this->assertEquals('Topik tidak boleh kosong.', session('errors')->get('topic')[0]);
    }

    public function test_gagal_mengubah_perangkat_dengan_duplicate_topic()
    {
        $sameTopic = 'finbites/test1';
        Device::factory()->create(['name' => 'Kolam 01', 'topic' => $sameTopic, 'user_id' => $this->user->id]);

        $this->assertDatabaseHas('devices', [
            'user_id' => $this->user->id,
            'name' => 'Kolam 01',
            'topic' => $sameTopic,
        ]);

        $device = Device::factory()->create(['name' => 'Kolam 03', 'topic' => 'finbites/test3', 'user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'topic' => $sameTopic,
            'capacity' => 12,
        ]);

        $response->assertSessionHasErrors('topic');
        $this->assertEquals('Topik yang diinputkan sudah terpakai.', session('errors')->get('topic')[0]);
    }

    public function test_gagal_mengubah_perangkat_tanpa_kapasitas()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'topic' => 'finbites/test3',
        ]);

        $response->assertSessionHasErrors('capacity');
        $this->assertEquals('Kapasitas tidak boleh kosong.', session('errors')->get('capacity')[0]);
    }

    public function test_gagal_mengubah_perangkat_dengan_kapasitas_kurang_dari_2()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'topic' => 'finbites/test3',
            'capacity' => 1,
        ]);

        $response->assertSessionHasErrors('capacity');
        $this->assertEquals('Kapasitas minimal 2.', session('errors')->get('capacity')[0]);
    }

    public function test_gagal_mengubah_perangkat_dengan_kapasitas_lebih_dari_12()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'name' => 'Kolam 03',
            'topic' => 'finbites/test3',
            'capacity' => 15,
        ]);

        $response->assertSessionHasErrors('capacity');
        $this->assertEquals('Kapasitas maksimal 12.', session('errors')->get('capacity')[0]);
    }

    public function test_berhasil_mengubah_perangkat_dengan_data_valid()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        $response = $this->withoutMiddleware()->put("/devices/admin/{$device->id}", [
            'user_id' => $this->user->id,
            'name' => 'Kolam 33',
            'topic' => 'finbites/test33',
            'capacity' => 10,
        ]);

        $response->assertRedirect(route('devices.index'));
        $response->assertSessionHas('toast_success', 'Data Kolam 33 berhasil diperbarui');
    }

    public function test_berhasil_menghapus_perangkat()
    {
        $device = Device::factory()->create(['user_id' => $this->user->id]);
        Log::info('Device id:', ['device' => $device->id]);

        // $response = $this->withoutMiddleware()->delete("/devices/admin/{$device->id}/delete");
        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->deleteJson('/devices/admin/' . $device->id .'/delete');

        $response->assertRedirect(route('devices.index'));
        $response->assertSessionHas('toast_success', "Data $device->name berhasil berhasil dihapus");
    }
}