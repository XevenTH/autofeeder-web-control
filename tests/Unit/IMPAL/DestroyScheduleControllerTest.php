<?php

namespace Tests\Unit\IMPAL;

use App\Models\User;
use App\Models\Device;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Mockery;

class DestroyScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $device;
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();
        // Membuat pengguna untuk pengujian
        // Periksa ketersediaan akun tester
        $tester = User::where('email', 'admin@finbites.com')->first();
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
        $this->actingAs($this->user);

        // Mocking GuzzleHttp Client
        $this->client = Mockery::mock(Client::class);
        $this->app->instance(Client::class, $this->client);
        $this->startSession(); // Ensure the session is started
    }

    public function test_destroy()
    {
        $schedule = Schedule::factory()->create(['device_id' => $this->device->id]);

        // // Debugging: Check session data
        // $sessionData = session()->all();
        // Log::info('Session Data anjas:', $sessionData);

        // Menggunakan CSRF token dalam header
        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->deleteJson('/schedules/admin/' . $schedule->id .'/delete');

        $response->assertStatus(302); // Resource yang di-request telah dipindahkan sementara ke lokasi baru (permintaan HTTP berhasil)
        $this->assertDatabaseMissing($schedule); // Memastikan data tidak ada di database
    }

    public function test_destroy_returns_404_for_nonexistent_schedule()
    {
        // Menggunakan CSRF token dalam header
        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->deleteJson('/schedules/admin/' . 99 .'/delete');
        
        // Memastikan respons adalah 404
        $response->assertStatus(404);
    }

    public function test_destroy_refresh_failed()
    {
        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'http://localhost:3000/api/refresh')
            ->andThrow(new RequestException("Error Communicating with Server", new \GuzzleHttp\Psr7\Request('POST', 'http://localhost:3000/api/refresh')));

        $schedule = Schedule::factory()->create(['device_id' => $this->device->id]);

        // Menggunakan CSRF token dalam header
        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->deleteJson('/schedules/admin/' . $schedule->id .'/delete');

        $response->assertStatus(302); // Resource yang di-request telah dipindahkan sementara ke lokasi baru (permintaan HTTP berhasil)
        $this->assertDatabaseMissing($schedule); // Memastikan data tidak ada di database

        $response->assertSessionHas('toast_error', "Gagal menyegarkan jadwal di server: Error Communicating with Server");
    }
}