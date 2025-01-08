<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat admin user jika belum ada
        $this->adminUser = User::factory()->create([
            'name' => 'Tester',
            'email' => 'admin@finbites.com',
            'phone' => '0895429412500',
            'password' => Hash::make('88888888'),
        ]);

        // Login sebagai admin
        $this->actingAs($this->adminUser);
    }

    public function test_index_displays_users()
    {
        User::factory()->count(5)->create();

        $response = $this->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    public function test_store_creates_new_user()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'password' =>  Hash::make('password123'),
        ]);

        $response = $this->post(route('users.store'), $user->toArray());
        $response->assertRedirect('http://localhost');

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    public function test_update_edits_user_data_No_Name()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password123'),
        ]);

        $newData = [
            'email' => 'johnNew@example.com',
            'phone' => '1234567890',
            'newpassword' => 'newpassword123',
        ];

        $response = $this->put(route('users.update', $user->id), $newData);
        $response->assertStatus(302);

        $user = User::where('email', 'johnNew@example.com')->first();

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe (New)',
            'email' => 'johnNew@example.com',
        ]);
    }

    public function test_destroy_deletes_user()
    {
        $user = User::factory()->create([
            'name' => 'John Doe (New)',
            'email' => 'johnNew@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('newpassword123'),
        ]);

        $response = $this->delete(route('users.destroy', $user->id));
        $this->assertNotNull($user, 'Updated user was not found in the database.');
        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
