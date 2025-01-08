<?php

namespace Tests\Feature;

use App\Models\Schedule;
use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); // Membuat user untuk autentikasi
    }

    public function test_guest_cannot_access_schedules()
    {
        $response = $this->get('/schedules');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_schedules()
    {
        $this->actingAs($this->user);

        $schedule = Schedule::factory()->create();

        $response = $this->get('/schedules');

        $response->assertStatus(200)
            ->assertViewIs('schedules.simple')
            ->assertSee($schedule->days);
    }

    // tests/Feature/ScheduleControllerTest.php

    public function test_authenticated_user_can_create_schedule()
    {
        // Melakukan login sebagai user yang sudah terautentikasi
        $this->actingAs($this->user);

        // Membuat perangkat yang terkait dengan user
        $device = Device::factory()->create(['user_id' => $this->user->id]);

        // Membuat payload untuk request
        $payload = [
            'device_id' => $device->id,
            'active' => true,
            'days' => 'Mon,Tue',
            'time' => '08:00:00',
            'grams_per_feeding' => 100,
            'servo_seconds' => 5,
        ];

        // Mengirim permintaan POST untuk membuat jadwal
        $response = $this->post(route('schedules.store'), $payload);

        // Memastikan redirect ke halaman schedules setelah berhasil membuat jadwal
        $response->assertRedirect('/schedules');

        // Memastikan data jadwal ada di database
        $this->assertDatabaseHas('schedules', $payload);
    }



    public function test_authenticated_user_can_update_schedule()
    {
        $this->actingAs($this->user);

        $device = Device::factory()->create(['user_id' => $this->user->id]);
        $schedule = Schedule::factory()->create(['device_id' => $device->id]);

        $payload = [
            'active' => false,
            'days' => 'Wed,Thu',
            'time' => '12:00:00',
            'grams_per_feeding' => 200,
            'servo_seconds' => 8,
        ];

        $response = $this->put("/schedules/{$schedule->id}", $payload);

        $response->assertRedirect('/schedules');
        $this->assertDatabaseHas('schedules', $payload + ['id' => $schedule->id]);
    }


    public function test_authenticated_user_can_delete_schedule()
    {
        $this->actingAs($this->user);

        $schedule = Schedule::factory()->create();

        $response = $this->delete("/schedules/{$schedule->id}/delete");

        $response->assertRedirect('/schedules');
        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }
}
