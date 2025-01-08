<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;

class authTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    /** @test */
    public function user_can_register_successfully()
    {
        $newUserData = [
            'name' => 'New Test User',
            'email' => 'newtester@finbites.com',
            'phone' => '08954294125',
            'password' => '99999999',
            'password_confirmation' => '99999999',
        ];

        $response = $this->post(route('register.post'), $newUserData);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('toast_success', 'Akun berhasil didaftarkan. Silahkan login!');
        
        // Remove password fields for database assertion
        unset($newUserData['password'], $newUserData['password_confirmation']);
        $this->assertDatabaseHas('users', $newUserData);
    }

    /** @test */
    public function user_registration_fails_with_invalid_data()
    {
        $response = $this->post(route('register.post'), [
            'name' => '',
            'email' => 'invalidemail',
            'phone' => '',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'password']);
    }

    /** @test */
    public function user_can_login_successfully()
    {
        $response = $this->post(route('login.post'), [
            'email' => 'admin@finbites.com',
            'password' => '88888888'
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('toast_success', 'Login berhasil');
        $this->assertAuthenticatedAs(User::where('email', 'admin@finbites.com')->first());
    }

    /** @test */
    public function user_login_fails_with_invalid_credentials()
    {
        $response = $this->post(route('login.post'), [
            'email' => 'admin@finbites.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('toast_error', 'Email atau Password salah');
        $this->assertGuest();
    }

    /** @test */
    public function user_can_logout_successfully()
    {
        $user = User::where('email', 'admin@finbites.com')->first();
        $this->actingAs($user);

        $response = $this->delete(route('logout'));
        
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /** @test */
    public function forgot_password_route_redirects_correctly()
    {
        $response = $this->post(route('recovery.post'), [
            'email' => 'dewangga@gmail.com'
        ]);

        $response->assertRedirect('/password-reset');
    }

    /** @test */
    public function reset_password_route_redirects_correctly()
    {
        $response = $this->post(route('passreset.post'), [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect('/');
    }

    /** @test */
    public function register_view_is_accessible()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    /** @test */
    public function login_view_is_accessible()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }
}