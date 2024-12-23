<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id' => \App\Models\Device::factory(), // Associate with a user
            'active' => 1,
            'days' => 'Monday Tuesday Wednesday Thursday Friday Saturday Sunday',
            'time' => '12:00',
            'grams_per_feeding' => 200,
            'servo_seconds' => 6700,
        ];
    }
}
