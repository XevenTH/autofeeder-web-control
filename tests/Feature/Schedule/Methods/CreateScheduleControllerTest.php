<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateScheduleControllerTest extends TestCase
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

    public function test_create_returns_view_with_devices()
    {
        // Membuat beberapa perangkat untuk pengguna
        $device1 = Device::factory()->create(['user_id' => $this->user->id]);
        $device2 = Device::factory()->create(['user_id' => $this->user->id]);

        // Mengirim permintaan ke metode create
        $response = $this->get(route('schedules.create'));

        // Memastikan respons adalah tampilan yang benar
        $response->assertStatus(200); // Memastikan status respons adalah 200
        $response->assertViewIs('schedule.create'); // Memastikan tampilan yang dikembalikan adalah 'schedule.create'
        
        // Memastikan data yang dikirim ke tampilan adalah benar
        $response->assertViewHas('devices', function ($devices) use ($device1, $device2) {
            return $devices->contains($device1) && $devices->contains($device2);
        });
    }
}
