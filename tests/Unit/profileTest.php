<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    /** @test */
    public function user_can_update_profile_without_password()
    {
        $user = User::where('email', 'admin@finbites.com')->first();
        $this->actingAs($user);

        $response = $this->put(route('users.simple.update', $user->id), [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@finbites.com',
            'phone' => '089542941251',
        ]);

        $response->assertRedirect(route('users.simple'));
        $response->assertSessionHas('toast_success', 'Data Profilmu berhasil diperbarui');
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@finbites.com',
            'phone' => '089542941251',
        ]);
    }

    /** @test */
    public function user_can_update_profile_with_password()
    {
        $user = User::where('email', 'admin@finbites.com')->first();
        $this->actingAs($user);

        $response = $this->put(route('users.simple.update', $user->id), [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@finbites.com',
            'phone' => '089542941251',
            'newpassword' => 'newpassword123',
            'newpassword_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('users.simple'));
        $response->assertSessionHas('toast_success', 'Data Profilmu berhasil diperbarui');

        $updatedUser = User::find($user->id);
        $this->assertTrue(Hash::check('newpassword123', $updatedUser->password));
    }

    /** @test */
    public function profile_update_fails_with_invalid_data()
    {
        $user = User::where('email', 'admin@finbites.com')->first();
        $this->actingAs($user);

        $response = $this->put(route('users.simple.update', $user->id), [
            'id' => $user->id,
            'name' => 'ab', // too short
            'email' => 'invalid-email',
            'phone' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'phone']);
    }

    /** @test */
    public function profile_update_fails_with_existing_email()
    {
        $user = User::where('email', 'admin@finbites.com')->first();
        $this->actingAs($user);

        $response = $this->put(route('users.simple.update', $user->id), [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'dewangga@gmail.com', // email yang sudah ada di database
            'phone' => '089542941251',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function profile_update_fails_with_mismatched_password_confirmation()
    {
        $user = User::where('email', 'admin@finbites.com')->first();
        $this->actingAs($user);

        $response = $this->put(route('users.simple.update', $user->id), [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@finbites.com',
            'phone' => '089542941251',
            'newpassword' => 'newpassword123',
            'newpassword_confirmation' => 'differentpassword123',
        ]);

        $response->assertSessionHasErrors(['newpassword']);
    }

    /** @test */
    public function profile_update_fails_with_short_password()
    {
        $user = User::where('email', 'admin@finbites.com')->first();
        $this->actingAs($user);

        $response = $this->put(route('users.simple.update', $user->id), [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@finbites.com',
            'phone' => '089542941251',
            'newpassword' => '123',
            'newpassword_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors(['newpassword']);
    }

    /** @test */
    public function unauthenticated_user_cannot_update_profile()
    {
        $user = User::where('email', 'admin@finbites.com')->first();

        $response = $this->put(route('users.simple.update', $user->id), [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@finbites.com',
            'phone' => '089542941251',
        ]);

        $response->assertRedirect(route('login'));
    }
}