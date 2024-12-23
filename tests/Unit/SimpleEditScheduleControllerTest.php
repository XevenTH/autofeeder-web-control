<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Device;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SimpleEditScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Membuat pengguna untuk pengujian
        $this->user = User::factory()->create();
        $this->actingAs($this->user); // Mengautentikasi pengguna
    }

    public function test_simple_edit_returns_view_with_schedule_devices_and_schedules()
    {
        // Membuat perangkat untuk pengguna
        $device = Device::factory()->create(['user_id' => $this->user->id]);
        
        // Membuat jadwal yang terkait dengan perangkat
        $schedule = Schedule::factory()->create(['device_id' => $device->id, 'days' => 'Monday Tuesday']);

        // Membuat beberapa jadwal lain untuk pengguna
        $schedule1 = Schedule::factory()->create(['device_id' => $device->id]);
        $schedule2 = Schedule::factory()->create(['device_id' => $device->id]);

        // Mengirim permintaan ke metode simpleEdit
        $response = $this->get(route('schedules.simple.edit', $schedule));

        // Memastikan respons adalah tampilan yang benar
        $response->assertStatus(200); // Memastikan status respons adalah 200
        $response->assertViewIs('schedule.simple'); // Memastikan tampilan yang dikembalikan adalah 'schedule.simple'
        
        // Memastikan data yang dikirim ke tampilan adalah benar
        $response->assertViewHas('schedule', function ($returnedSchedule) use ($schedule) {
            return $returnedSchedule->id === $schedule->id;
        });

        $response->assertViewHas('schedules', function ($schedules) use ($schedule1, $schedule2, $device) {
            // Memeriksa apakah jadwal yang dikembalikan memiliki data yang diharapkan setelah join
            return $schedules->contains(function ($item) use ($schedule1, $schedule2, $device) {
                return $item->id === $schedule1->id && $item->device_id === $device->id ||
                       $item->id === $schedule2->id && $item->device_id === $device->id;
            });
        });

        $response->assertViewHas('devices', function ($devices) use ($device) {
            return $devices->contains($device);
        });

        // Memastikan scheduled_days berisi hari yang benar
        $response->assertViewHas('scheduled_days', function ($scheduled_days) {
            return isset($scheduled_days['monday']) && $scheduled_days['monday'] === 1 &&
                   isset($scheduled_days['tuesday']) && $scheduled_days['tuesday'] === 1 &&
                   count($scheduled_days) === 2; // Hanya ada Monday dan Tuesday
        });
    }

    public function test_simple_edit_returns_404_for_nonexistent_schedule()
    {
        // Mengirim permintaan ke metode simpleEdit dengan jadwal yang tidak ada
        $response = $this->get(route('schedules.simple.edit', ['schedule' => 999]));

        // Memastikan respons adalah 404
        $response->assertStatus(404);
    }
}