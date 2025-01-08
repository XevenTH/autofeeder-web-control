<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'device_id' => Device::factory(),
            'active' => 1,
            'days' => 'Monday Tuesday',
            'time' => fake()->time('H:i:s'),
            'grams_per_feeding' => fake()->numberBetween(30, 1000),
            'servo_seconds' => fake()->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}