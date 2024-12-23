<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Device;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Mockery;

class DeleteScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $device;
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->device = Device::factory()->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user);

        // Mocking GuzzleHttp Client
        $this->client = Mockery::mock(Client::class);
        $this->app->instance(Client::class, $this->client);
    }

    public function test_delete()
    {
        $schedule = Schedule::factory()->create(['device_id' => $this->device->id]);

        $response = $this->deleteJson('/schedules/' . $schedule->id .'/delete');

        $response->assertStatus(302); // Resource yang di-request telah dipindahkan sementara ke lokasi baru (permintaan HTTP berhasil)
        $this->assertDatabaseMissing($schedule); // Memastikan data tidak ada di database
    }

    public function test_delete_refresh_failed()
    {
        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'http://localhost:3000/api/refresh')
            ->andThrow(new RequestException("Error Communicating with Server", new \GuzzleHttp\Psr7\Request('POST', 'test')));

        $schedule = Schedule::factory()->create(['device_id' => $this->device->id]);

        $response = $this->deleteJson('/schedules/' . $schedule->id .'/delete');

        $response->assertStatus(302); // Resource yang di-request telah dipindahkan sementara ke lokasi baru (permintaan HTTP berhasil)
        $this->assertDatabaseMissing($schedule); // Memastikan data tidak ada di database

        $response->assertSessionHas('toast_error', "Gagal menyegarkan jadwal di server: Error Communicating with Server");
    }
}