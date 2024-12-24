<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Device;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimpleShowScheduleControllerTest extends TestCase
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

    public function test_simple_show_returns_view_with_schedules_and_devices()
    {
        // Membuat beberapa jadwal dan perangkat untuk pengguna
        $device1 = Device::factory()->create(['user_id' => $this->user->id]);
        $device2 = Device::factory()->create(['user_id' => $this->user->id]);
        
        $schedule1 = Schedule::factory()->create(['device_id' => $device1->id]);
        $schedule2 = Schedule::factory()->create(['device_id' => $device2->id]);

        // Mengirim permintaan ke metode simpleShow
        $response = $this->get(route('schedules.simple'));

        // Memastikan respons adalah tampilan yang benar
        $response->assertStatus(200); // Memastikan status respons adalah 200
        $response->assertViewIs('schedule.simple'); // Memastikan tampilan yang dikembalikan adalah 'schedule.simple'
        
        // Memastikan data yang dikirim ke tampilan adalah benar
        $response->assertViewHas('schedules', function ($schedules) use ($schedule1, $schedule2, $device1, $device2) {
            // Memeriksa apakah jadwal yang dikembalikan memiliki data yang diharapkan setelah join
            return $schedules->contains(function ($item) use ($schedule1, $schedule2, $device1, $device2) {
                return $item->id === $schedule1->id && $item->device_id === $device1->id ||
                       $item->id === $schedule2->id && $item->device_id === $device2->id;
            });
        });

        $response->assertViewHas('devices', function ($devices) use ($device1, $device2) {
            return $devices->contains($device1) && $devices->contains($device2);
        });
    }

    public function test_simple_show_returns_empty_when_no_schedules_or_devices()
    {
        // Mengirim permintaan ke metode simpleShow
        $response = $this->get(route('schedules.simple'));

        // Memastikan respons adalah tampilan yang benar
        $response->assertStatus(200); // Memastikan status respons adalah 200
        $response->assertViewIs('schedule.simple'); // Memastikan tampilan yang dikembalikan adalah 'schedule.simple'
        
        // Memastikan tidak ada jadwal dan perangkat yang dikirim ke tampilan
        $response->assertViewHas('schedules', function ($schedules) {
            return $schedules->isEmpty();
        });

        $response->assertViewHas('devices', function ($devices) {
            return $devices->isEmpty();
        });
    }
}