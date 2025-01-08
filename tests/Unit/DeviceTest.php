<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    public function test_devices_table_has_expected_columns()
    {
        $columns = Schema::getColumnListing('devices');

        $this->assertTrue(in_array('id', $columns));
        $this->assertTrue(in_array('user_id', $columns));
        $this->assertTrue(in_array('name', $columns));
        $this->assertTrue(in_array('topic', $columns));
        $this->assertTrue(in_array('capacity', $columns));
        $this->assertTrue(in_array('created_at', $columns));
        $this->assertTrue(in_array('updated_at', $columns));
    }

    public function test_devices_table_user_foreign_key()
    {
        $user = User::factory()->create(['phone' => '1234567890']);
        $device = Device::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $device->user_id);
    }

    public function test_device_cascade_on_user_delete()
    {
        $user = User::factory()->create(['phone' => '1234567890']);
        $device = Device::factory()->create(['user_id' => $user->id]);

        $user->delete();

        $this->assertDatabaseMissing('devices', ['id' => $device->id]);
    }

    public function test_device_creation()
    {
        $user = User::factory()->create(['phone' => '1234567890']);
        $device = Device::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Device',
            'topic' => 'Test Topic',
            'capacity' => 100.5,
        ]);

        $this->assertDatabaseHas('devices', [
            'id' => $device->id,
            'name' => 'Test Device',
            'topic' => 'Test Topic',
            'capacity' => 100.5,
        ]);
    }

    public function test_device_read()
    {
        $user = User::factory()->create(['phone' => '1234567890']);
        $device = Device::factory()->create(['user_id' => $user->id]);

        $foundDevice = Device::find($device->id);

        $this->assertNotNull($foundDevice);
        $this->assertEquals($device->id, $foundDevice->id);
    }

    public function test_device_update()
    {
        $user = User::factory()->create(['phone' => '1234567890']);
        $device = Device::factory()->create([
            'user_id' => $user->id,
            'name' => 'Old Device Name',
        ]);

        $device->update(['name' => 'Updated Device Name']);

        $this->assertDatabaseHas('devices', [
            'id' => $device->id,
            'name' => 'Updated Device Name',
        ]);
    }

    public function test_device_delete()
    {
        $user = User::factory()->create(['phone' => '1234567890']);
        $device = Device::factory()->create(['user_id' => $user->id]);

        $device->delete();

        $this->assertDatabaseMissing('devices', ['id' => $device->id]);
    }
}
