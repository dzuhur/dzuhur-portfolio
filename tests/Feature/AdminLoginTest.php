<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    private const PASSWORD = 'correct-horse-battery';

    private function createAdmin(): User
    {
        return User::factory()->create([
            'email' => 'admin@example.com',
            'password' => self::PASSWORD,
        ]);
    }

    public function test_login_page_can_be_opened_by_guests(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Admin login');
    }

    public function test_admin_can_log_in_with_correct_credentials(): void
    {
        $admin = $this->createAdmin();

        $response = $this->post(route('login.store'), [
            'email' => 'admin@example.com',
            'password' => self::PASSWORD,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $this->createAdmin();

        $response = $this->post(route('login.store'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_wrong_email_and_wrong_password_show_the_same_message(): void
    {
        $this->createAdmin();
        $genericMessage = 'These credentials do not match our records.';

        // Email terdaftar, password salah
        $this->post(route('login.store'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors(['email' => $genericMessage]);

        // Email tidak terdaftar
        $this->post(route('login.store'), [
            'email' => 'nobody@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors(['email' => $genericMessage]);
    }

    public function test_password_is_never_sent_back_to_the_form(): void
    {
        $this->createAdmin();

        $this->post(route('login.store'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertSame('admin@example.com', session()->getOldInput('email'));
        $this->assertNull(session()->getOldInput('password'));
    }

    public function test_login_is_blocked_after_five_failed_attempts(): void
    {
        $this->createAdmin();

        for ($i = 1; $i <= 5; $i++) {
            $this->post(route('login.store'), [
                'email' => 'admin@example.com',
                'password' => 'wrong-password',
            ]);
        }

        // Percobaan ke-6 ditolak, BAHKAN dengan password yang benar
        $response = $this->post(route('login.store'), [
            'email' => 'admin@example.com',
            'password' => self::PASSWORD,
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Too many login attempts. Please try again in a minute.',
        ]);
        $this->assertNull(session()->getOldInput('password'));
        $this->assertGuest();
    }

    public function test_admin_can_log_out(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('logout'));

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }
}