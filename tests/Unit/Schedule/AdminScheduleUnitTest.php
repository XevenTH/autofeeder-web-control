<?php

namespace Tests\Unit\Schedule;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Schedule;
use App\Http\Controllers\ScheduleController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AdminScheduleUnitTest extends TestCase
{
    use RefreshDatabase;

    protected $scheduleController;
    protected $user;
    protected $device;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scheduleController = new ScheduleController(new \GuzzleHttp\Client());
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
        $this->device = Device::factory()->create(['user_id' => $this->user->id]);
        $this->startSession(); // Ensure the session is started
    }

    public function test_gagal_menambahkan_jadwal_tanpa_data_perangkat()
    {        
        $response = $this->withoutMiddleware()->post('/schedules/admin', [
            'time' => '08:00',
            'grams_per_feeding' => 50,
        ]);

        $response->assertSessionHasErrors('device_id');
        $this->assertEquals('Perangkat tidak boleh kosong.', session('errors')->get('device_id')[0]);
    }

    public function test_gagal_menambahkan_jadwal_tanpa_data_jam()
    {
        // $device = Device::factory()->create();
        
        $response = $this->withoutMiddleware()->post('/schedules/admin', [
            'device_id' => $this->device->id,
            'grams_per_feeding' => 50,
        ]);

        $response->assertSessionHasErrors('time');
        $this->assertEquals('Jam tidak boleh kosong.', session('errors')->get('time')[0]);
    }

    public function test_gagal_menambahkan_jadwal_tanpa_data_takaran_per_pakan()
    {
        // $device = Device::factory()->create();
        
        $response = $this->withoutMiddleware()->post('/schedules/admin', [
            'device_id' => $this->device->id,
            'time' => '08:00',
        ]);

        $response->assertSessionHasErrors('grams_per_feeding');
        $this->assertEquals('Takaran per pakan tidak boleh kosong.', session('errors')->get('grams_per_feeding')[0]);
    }

    public function test_gagal_menambahkan_jadwal_dengan_data_takaran_per_pakan_kurang_dari_30()
    {
        // $device = Device::factory()->create();
        
        $response = $this->withoutMiddleware()->post('/schedules/admin', [
            'device_id' => $this->device->id,
            'time' => '08:00',
            'grams_per_feeding' => 20,
        ]);

        $response->assertSessionHasErrors('grams_per_feeding');
        $this->assertEquals('Tarakan per pakan minimal 30 gram.', session('errors')->get('grams_per_feeding')[0]);
    }

    public function test_gagal_menambahkan_jadwal_dengan_data_takaran_per_pakan_lebih_dari_1000()
    {
        // $device = Device::factory()->create();
        
        $response = $this->withoutMiddleware()->post('/schedules/admin', [
            'device_id' => $this->device->id,
            'time' => '08:00',
            'grams_per_feeding' => 1500,
        ]);

        $response->assertSessionHasErrors('grams_per_feeding');
        $this->assertEquals('Tarakan per pakan maksimal 1000 gram.', session('errors')->get('grams_per_feeding')[0]);
    }

    public function test_berhasil_menambahkan_jadwal_dengan_data_valid()
    {
        // $device = Device::factory()->create();
        
        $response = $this->withoutMiddleware()->post('/schedules/admin', [
            'device_id' => $this->device->id,
            'time' => '08:00',
            'grams_per_feeding' => 50,
        ]);

        $response->assertRedirect(route('schedules.index'));
        $response->assertSessionHas('toast_success', 'Data jadwal berhasil ditambahkan');
    }

    // public function test_gagal_mengubah_jadwal_tanpa_data_perangkat()
    // {
    //     $schedule = Schedule::factory()->create();

    //     $response = $this->withoutMiddleware()->put("/schedules/admin/{$schedule->id}", [
    //         'time' => '08:00',
    //         'grams_per_feeding' => 50,
    //     ]);

    //     $response->assertSessionHasErrors('device_id');
    //     $this->assertEquals('Perangkat tidak boleh kosong.', session('errors')->get('device_id')[0]);
    // }

    public function test_gagal_mengubah_jadwal_tanpa_data_jam()
    {
        // $device = Device::factory()->create();

        $schedule = Schedule::factory()->create();

        $response = $this->withoutMiddleware()->put("/schedules/admin/{$schedule->id}", [
            'device_id' => $this->device->id,
            'grams_per_feeding' => 50,
        ]);

        $response->assertSessionHasErrors('time');
        $this->assertEquals('Jam tidak boleh kosong.', session('errors')->get('time')[0]);
    }

    public function test_gagal_mengubah_jadwal_tanpa_data_takaran_per_pakan()
    {
        // $device = Device::factory()->create();

        $schedule = Schedule::factory()->create();

        $response = $this->withoutMiddleware()->put("/schedules/admin/{$schedule->id}", [
            'device_id' => $this->device->id,
            'time' => '08:00',
        ]);

        $response->assertSessionHasErrors('grams_per_feeding');
        $this->assertEquals('Takaran per pakan tidak boleh kosong.', session('errors')->get('grams_per_feeding')[0]);
    }

    public function test_gagal_mengubah_jadwal_dengan_data_takaran_per_pakan_kurang_dari_30()
    {
        // $device = Device::factory()->create();

        $schedule = Schedule::factory()->create();

        $response = $this->withoutMiddleware()->put("/schedules/admin/{$schedule->id}", [
            'device_id' => $this->device->id,
            'time' => '08:00',
            'grams_per_feeding' => 20,
        ]);

        $response->assertSessionHasErrors('grams_per_feeding');
        $this->assertEquals('Tarakan per pakan minimal 30 gram.', session('errors')->get('grams_per_feeding')[0]);
    }

    public function test_gagal_mengubah_jadwal_dengan_data_takaran_per_pakan_lebih_dari_1000()
    {
        // $device = Device::factory()->create();

        $schedule = Schedule::factory()->create();

        $response = $this->withoutMiddleware()->put("/schedules/admin/{$schedule->id}", [
            'device_id' => $this->device->id,
            'time' => '08:00',
            'grams_per_feeding' => 1500,
        ]);

        $response->assertSessionHasErrors('grams_per_feeding');
        $this->assertEquals('Tarakan per pakan maksimal 1000 gram.', session('errors')->get('grams_per_feeding')[0]);
    }

    public function test_berhasil_mengubah_jadwal_dengan_data_valid()
    {
        // $device = Device::factory()->create();

        $schedule = Schedule::factory()->create();

        $response = $this->withoutMiddleware()->put("/schedules/admin/{$schedule->id}", [
            'device_id' => $this->device->id,
            'time' => '08:00',
            'grams_per_feeding' => 50,
        ]);

        $response->assertRedirect(route('schedules.index'));
        $response->assertSessionHas('toast_success', 'Data jadwal berhasil diperbarui');
    }

    public function test_berhasil_menghapus_data()
    {
        $schedule = Schedule::factory()->create();

        $response = $this->withoutMiddleware()->delete("/schedules/admin/{$schedule->id}/delete");

        $response->assertRedirect(route('schedules.index'));
        $response->assertSessionHas('toast_success', 'Data jadwal berhasil dihapus');
    }
}