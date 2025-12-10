<?php

namespace Tests\Unit\IMPAL;

use App\Models\User;
use App\Models\Device;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

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
        $this->actingAs($this->user); // Mengautentikasi pengguna
    }

    public function test_edit_returns_view_with_schedule_devices_and_scheduled_days()
    {
        // Membuat perangkat untuk pengguna
        $device1 = Device::factory()->create(['user_id' => $this->user->id]);
        $device2 = Device::factory()->create(['user_id' => $this->user->id]);
        
        // Membuat jadwal yang terkait dengan perangkat
        $schedule = Schedule::factory()->create(['device_id' => $device1->id, 'days' => 'Monday Wednesday']);

        // Mengirim permintaan ke metode edit
        $response = $this->get(route('schedules.edit', $schedule));

        // Memastikan respons adalah tampilan yang benar
        $response->assertStatus(200); // Memastikan status respons adalah 200
        $response->assertViewIs('schedule.edit'); // Memastikan tampilan yang dikembalikan adalah 'schedule.edit'
        
        // Memastikan data yang dikirim ke tampilan adalah benar
        $response->assertViewHas('schedule', $schedule); // Memastikan jadwal yang dikembalikan adalah yang benar
        $response->assertViewHas('devices', function ($devices) use ($device1, $device2) {
            return $devices->contains($device1) && $devices->contains($device2);
        });

        // Memastikan scheduled_days berisi hari yang benar
        $response->assertViewHas('scheduled_days', function ($scheduled_days) {
            return isset($scheduled_days['monday']) && $scheduled_days['monday'] === 1 &&
                   isset($scheduled_days['wednesday']) && $scheduled_days['wednesday'] === 1 &&
                   count($scheduled_days) === 2; // Hanya ada Monday dan Wednesday
        });
    }

    public function test_edit_returns_404_for_nonexistent_schedule()
    {
        // Mengirim permintaan ke metode edit dengan jadwal yang tidak ada
        $response = $this->get(route('schedules.edit', ['schedule' => 999]));

        // Memastikan respons adalah 404
        $response->assertStatus(404);
    }
}