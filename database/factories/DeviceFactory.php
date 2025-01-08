<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Ini akan otomatis membuat user baru
            'name' => fake()->word(),
            'topic' => fake()->word(),
            'capacity' => fake()->randomFloat(2, 1, 10),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}