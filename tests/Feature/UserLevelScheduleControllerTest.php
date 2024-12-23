<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Device;
use App\Models\Schedule;
use App\Models\User;

class UserLevelScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $device;

    // setUp dijalankan setiap sebelum unit test
    protected function setUp(): void
    {
        parent::setUp();

        // Membuat pengguna dan perangkat untuk pengujian
        $this->user = User::factory()->create(); // Membuat pengguna
        $this->device = Device::factory()->create(['user_id' => $this->user->id]); // Membuat perangkat terkait dengan pengguna
        $this->actingAs($this->user); // Melakukan autentikasi sebagai pengguna
    }

    public function test_user_show_schedule()
    {
        $response = $this->get('/schedules');

        $response->assertStatus(200); // Server mengembalikan data yang diminta
    }

    public function test_user_store_schedule_success()
    {
        $response = $this->postJson('/schedules', [
            'device_id' => $this->device->id,
            'active' => 1,
            'days_monday' => 'Monday',
            'days_tuesday' => 'Tuesday',
            'days_wednesday' => 'Wednesday',
            'time' => '12:00',
            'grams_per_feeding' => 60,
        ]);
        
        $response->assertStatus(302); // Resource yang di-request telah dipindahkan sementara ke lokasi baru (permintaan HTTP berhasil)
        $this->assertDatabaseHas('schedules', [ // Memastikan data yang sudah diubah benar-benar ada di database
            'device_id' => $this->device->id,
            'active' => 1,
            'days' => 'Monday Tuesday Wednesday',
            'time' => '12:00',
            'grams_per_feeding' => 60,
        ]);
    }

    public function test_user_store_schedule_validation_failure()
    {
        $response = $this->postJson('/schedules', [
            'device_id' => 99, // id tidak ada
            'active' => 1,
            // Tidak ada input hari
            'time' => '', // kosong
            'grams_per_feeding' => 0, // dibawah batas minimum
        ]);

        $response->assertStatus(422); // Uprocessable Entity, tidak memenuhi kriteria validasi yang ditentukan oleh server
        $response->assertJsonValidationErrors(['device_id', 'time', 'grams_per_feeding']); // Memastikan ada kesalahan validasi
    }

    public function test_user_update_schedule_success()
    {
        $schedule = Schedule::factory()->create(['device_id' => $this->device->id]);

        $response = $this->putJson('/schedules/' . $schedule->id, [
            'device_id' => $this->device->id,
            'time' => '13:00',
            'grams_per_feeding' => 80,
            'days_wednesday' => 'Wednesday',
            'days_friday' => 'Friday',
        ]);

        $response->assertStatus(302); // Resource yang di-request telah dipindahkan sementara ke lokasi baru (permintaan HTTP berhasil)
        $this->assertDatabaseHas('schedules', [ // Memastikan data yang sudah diubah benar-benar ada di database
            'id' => $schedule->id,
            'time' => '13:00',
            'grams_per_feeding' => 80,
            'days' => 'Wednesday Friday',
        ]);
    }

    public function test_user_update_schedule_validation_failure()
    {
        $schedule = Schedule::factory()->create(['device_id' => $this->device->id]);

        $response = $this->putJson('/schedules/' . $schedule->id, [
            'device_id' => 99,
            'time' => '',
            'grams_per_feeding' => 50000,
            'days_wednesday' => 'Wednesday',
            'days_friday' => 'Friday',
        ]);

        $response->assertStatus(422); // Uprocessable Entity, tidak memenuhi kriteria validasi yang ditentukan oleh server
        $response->assertJsonValidationErrors(['device_id', 'time', 'grams_per_feeding']); // Memastikan ada kesalahan validasi
    }

    public function test_user_destroy_schedule_success()
    {
        $schedule = Schedule::factory()->create(['device_id' => $this->device->id]);

        $response = $this->deleteJson('/schedules/' . $schedule->id .'/delete');

        $response->assertStatus(302); // Resource yang di-request telah dipindahkan sementara ke lokasi baru (permintaan HTTP berhasil)
        $this->assertDatabaseMissing($schedule); // Memastikan data tidak ada di database
    }
}