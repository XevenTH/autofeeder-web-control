<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ScheduleController;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Device;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class ScheduleControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    protected ScheduleController $controller;
    protected $clientMock;
    protected $user;
    protected $device;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientMock = Mockery::mock(Client::class);
        $this->controller = new ScheduleController($this->clientMock);
        $this->user = User::factory()->create();
        $this->device = Device::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_unit_can_count_servo_seconds()
    {
        $grams = 60; // Contoh input
        $expectedSeconds = (60 / 30) * 1000; // Harusnya 2000

        $result = $this->controller->countServoSeconds($grams);

        $this->assertEquals($expectedSeconds, $result);
    }

    public function test_unit_validates_store_request()
    {
        $request = Request::create('/schedules', 'POST', [
            'device_id' => 999,
            'time' => '',
            'grams_per_feeding' => 0,
            'active' => 1,
        ]);

        $validator = \Validator::make($request->all(), [
            'device_id' => 'required|exists:devices,id',
            'time' => 'required',
            'grams_per_feeding' => 'required|integer|lte:1000|gte:30',
            'active' => 'required|boolean',
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_unit_validates_update_request()
    {
        $schedule = Schedule::factory()->create(['device_id' => $this->device->id]);

        $request = Request::create('/schedules/' . $schedule->id, 'PUT', [
            'device_id' => 999,
            'time' => '',
            'grams_per_feeding' => 0,
            'active' => 1,
        ]);

        $validator = \Validator::make($request->all(), [
            'device_id' => 'required|exists:devices,id',
            'time' => 'required',
            'grams_per_feeding' => 'required|integer|lte:1000|gte:30',
            'active' => 'required|boolean',
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_unit_can_create_schedule()
    {
        // Simulasi request
        $request = Request::create('/schedules', 'POST', [
            'device_id' => $this->device->id,
            'time' => '12:00',
            'grams_per_feeding' => 60,
            'active' => 1,
            'days_monday' => 'Monday',
        ]);

        // Panggil method store
        $this->controller->store($request);

        // Verifikasi bahwa schedule disimpan
        $this->assertDatabaseHas('schedules', [
            'device_id' => $this->device->id,
            'time' => '12:00',
            'grams_per_feeding' => 60,
            'active' => 1,
            'days' => 'Monday ', // Hari yang dipilih
        ]);
    }

    public function test_unit_can_handle_api_refresh_on_create()
    {
        // Mocking GuzzleHttp\Client
        $this->clientMock->shouldReceive('request')
            ->once()
            ->with('POST', 'http://localhost:3000/api/refresh')
            ->andReturn(new Response(200, [], json_encode(['status' => 'success'])));

        // Simulasi request
        $request = Request::create('/schedules', 'POST', [
            'device_id' => $this->device->id,
            'time' => '12:00',
            'grams_per_feeding' => 60,
            'active' => 1,
            'days_monday' => 'Monday',
        ]);

        // Panggil method store
        $this->controller->store($request);

        // Verifikasi bahwa API refresh dipanggil
        $this->assertTrue(true); // Asumsi bahwa tidak ada exception yang dilempar
    }
}
