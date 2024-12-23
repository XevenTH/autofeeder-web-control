<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menyisipkan data produk ke dalam tabel users
        User::create([
            'name' => 'Tester',
            'email' => 'admin@finbites.com',
            'phone' => '0895429412500',
            'password' => Hash::make('88888888')
        ]);

        User::create([
            'name' => 'Dewa Angga',
            'email' => 'dewangga@gmail.com',
            'phone' => '0857824293',
            'password' => Hash::make('dddddddd')
        ]);

        User::create([
            'name' => 'Handy AH',
            'email' => 'handyAH@gmail.com',
            'phone' => '08753729343',
            'password' => Hash::make('hhhhhhhh')
        ]);
        
        User::create([
            'name' => 'Pandu RM',
            'email' => 'panduRM@gmail.com',
            'phone' => '08578248293',
            'password' => Hash::make('pppppppp')
        ]);

        Device::create([
            'user_id' => 1,
            'name' => 'Kolam 1',
            'topic' => 'finbites/test1',
            'capacity' => 12,
        ]);
    }
}
