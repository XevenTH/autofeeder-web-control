<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexScheduleControllerTest extends TestCase
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

    public function test_index_returns_view_with_schedules()
    {
        // Membuat beberapa jadwal untuk pengguna
        $schedule1 = Schedule::factory()->create();
        $schedule2 = Schedule::factory()->create();

        // Mengirim permintaan ke metode index
        $response = $this->get(route('schedules.index'));

        // Memastikan respons adalah tampilan yang benar
        $response->assertStatus(200); // Memastikan status respons adalah 200
        $response->assertViewIs('schedule.index'); // Memastikan tampilan yang dikembalikan adalah 'schedule.index'
        
        // Memastikan data yang dikirim ke tampilan adalah benar
        $response->assertViewHas('schedules', function ($schedules) use ($schedule1, $schedule2) {
            return $schedules->contains($schedule1) && $schedules->contains($schedule2);
        });
    }

    public function test_index_returns_view_with_no_schedules()
    {
        // Mengirim permintaan ke metode index tanpa jadwal
        $response = $this->get(route('schedules.index'));

        // Memastikan respons adalah tampilan yang benar
        $response->assertStatus(200); // Memastikan status respons adalah 200
        $response->assertViewIs('schedule.index'); // Memastikan tampilan yang dikembalikan adalah 'schedule.index'
        
        // Memastikan tidak ada jadwal yang dikirim ke tampilan
        $response->assertViewHas('schedules', function ($schedules) {
            return $schedules->isEmpty(); // Memastikan jadwal kosong
        });
    }
}
