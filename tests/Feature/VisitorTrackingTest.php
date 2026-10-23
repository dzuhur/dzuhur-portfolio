<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VisitorTrackingTest extends TestCase
{
    use RefreshDatabase;

    private const BROWSER = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0 Safari/537.36';

    private function visitAsBrowser(string $url = '/', array $headers = [])
    {
        return $this->withHeaders(array_merge(['User-Agent' => self::BROWSER], $headers))->get($url);
    }

    public function test_a_normal_visit_is_recorded(): void
    {
        $this->visitAsBrowser()->assertOk();

        $this->assertDatabaseCount('visitors', 1);
        $this->assertDatabaseHas('visitors', ['page' => '/']);
    }

    public function test_the_real_ip_address_is_never_stored(): void
    {
        $this->visitAsBrowser();

        $visitor = Visitor::first();

        // Hash SHA-256 selalu 64 karakter, dan tidak boleh mengandung IP asli
        $this->assertSame(64, strlen($visitor->ip_hash));
        $this->assertStringNotContainsString('127.0.0.1', $visitor->ip_hash);
    }

    public function test_only_the_referrer_domain_is_stored(): void
    {
        $this->visitAsBrowser('/', [
            'Referer' => 'https://www.instagram.com/dzuhurrr?igsh=secret123',
        ]);

        $this->assertDatabaseHas('visitors', ['referer' => 'www.instagram.com']);
        $this->assertDatabaseMissing('visitors', ['referer' => 'https://www.instagram.com/dzuhurrr?igsh=secret123']);
    }

    public function test_internal_navigation_is_not_stored_as_a_referrer(): void
    {
        $this->visitAsBrowser('/', ['Referer' => url('/#about')]);

        $this->assertDatabaseHas('visitors', ['page' => '/', 'referer' => null]);
    }

    public function test_bots_are_not_recorded(): void
    {
        $this->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1)'])->get('/');
        $this->withHeaders(['User-Agent' => 'curl/8.21.0'])->get('/');
        $this->withHeaders(['User-Agent' => 'python-requests/2.32'])->get('/');

        $this->assertDatabaseEmpty('visitors');
    }

    public function test_global_privacy_control_is_respected(): void
    {
        $this->visitAsBrowser('/', ['Sec-GPC' => '1']);

        $this->assertDatabaseEmpty('visitors');
    }

    public function test_logged_in_admin_is_not_recorded(): void
    {
        $this->actingAs(User::factory()->create());

        $this->visitAsBrowser();

        $this->assertDatabaseEmpty('visitors');
    }

    public function test_same_visitor_on_the_same_day_has_the_same_hash(): void
    {
        $this->visitAsBrowser();
        $this->visitAsBrowser();

        $this->assertDatabaseCount('visitors', 2);
        $this->assertSame(1, Visitor::distinct()->count('ip_hash'));
    }

    public function test_the_hash_changes_on_a_new_day(): void
    {
        $this->visitAsBrowser();

        $this->travelTo(now()->addDay());
        $this->visitAsBrowser();

        // IP sama, hari berbeda → hash berbeda (tidak bisa dilacak lintas hari)
        $this->assertSame(2, Visitor::distinct()->count('ip_hash'));
    }

    public function test_resume_downloads_are_recorded(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('resume.pdf', 'fake pdf content');

        $this->visitAsBrowser('/resume')->assertOk();

        $this->assertDatabaseHas('visitors', ['page' => '/resume']);
    }

    public function test_missing_resume_redirects_and_is_not_recorded_as_a_download(): void
    {
        Storage::fake('public');

        $this->visitAsBrowser('/resume')->assertRedirect();

        $this->assertDatabaseMissing('visitors', ['page' => '/resume']);
    }
}