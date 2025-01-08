<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Schedule;
use App\Models\Device;
use App\Models\User;
use App\Http\Controllers\ScheduleController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class ScheduleUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected $jadwal;
    protected $perangkat;
    protected $pengendali;
    protected $pengguna;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Buat pengguna
        $this->pengguna = User::factory()->create();
        
        // Inisialisasi pengendali
        $this->pengendali = new ScheduleController();
        
        // Buat perangkat uji dengan user_id tertentu
        $this->perangkat = Device::factory()->create([
            'user_id' => $this->pengguna->id
        ]);
        
        // Buat jadwal uji
        $this->jadwal = Schedule::factory()->create([
            'device_id' => $this->perangkat->id,
            'active' => 1,
            'days' => 'Monday Tuesday',
            'time' => '08:00',
            'grams_per_feeding' => 100,
            'servo_seconds' => 5
        ]);
    }

    #[Test]
    public function test_berhasil_memperbarui_jadwal()
    {
        $dataPermintaan = [
            'device_id' => $this->perangkat->id,
            'active' => 1,
            'days_monday' => 'Monday',
            'days_tuesday' => 'Tuesday',
            'time' => '09:00',
            'grams_per_feeding' => 500
        ];

        $permintaan = Request::create('/schedules/update', 'POST', $dataPermintaan);
        
        Http::fake([
            'http://localhost:3000/api/refresh' => Http::response([], 200)
        ]);

        $respon = $this->pengendali->update($permintaan, $this->jadwal);
        
        $this->assertDatabaseHas('schedules', [
            'id' => $this->jadwal->id,
            'device_id' => $this->perangkat->id,
            'active' => 1,
            'days' => 'Monday Tuesday ',
            'time' => '09:00',
            'grams_per_feeding' => 500
        ]);
    }

    #[Test]
    public function test_validasi_gagal()
    {
        $dataPermintaan = [
            'device_id' => 999999, // Perangkat tidak ada
            'time' => '09:00',
            'grams_per_feeding' => 2000 // Melebihi maksimum
        ];

        $permintaan = Request::create('/schedules/update', 'POST', $dataPermintaan);

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        
        $this->pengendali->update($permintaan, $this->jadwal);
    }

    #[Test]
    public function test_api_gagal()
    {
        $dataPermintaan = [
            'device_id' => $this->perangkat->id,
            'time' => '09:00',
            'grams_per_feeding' => 500
        ];

        $permintaan = Request::create('/schedules/update', 'POST', $dataPermintaan);

        Http::fake([
            'http://localhost:3000/api/refresh' => Http::response([], 500)
        ]);

        $respon = $this->pengendali->update($permintaan, $this->jadwal);
        
        $this->assertTrue($respon->isRedirect(route('schedules.index', ['device' => $this->jadwal->id])));
        $this->assertTrue(session()->has('toast_error'));
    }

    #[Test]
    public function test_hari_kosong()
    {
        $dataPermintaan = [
            'device_id' => $this->perangkat->id,
            'time' => '09:00',
            'grams_per_feeding' => 500
            // Tidak ada hari yang dipilih
        ];

        $permintaan = Request::create('/schedules/update', 'POST', $dataPermintaan);

        $respon = $this->pengendali->update($permintaan, $this->jadwal);
        
        $this->assertDatabaseHas('schedules', [
            'id' => $this->jadwal->id,
            'days' => '-'
        ]);
    }
}
