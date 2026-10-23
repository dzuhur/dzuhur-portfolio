<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data form yang valid. Field tertentu bisa ditimpa lewat $overrides.
     */
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Recruiter Test',
            'email' => 'recruiter@example.com',
            'message' => 'Hi Dzuhur, I would like to talk about a role.',
        ], $overrides);
    }

    public function test_a_valid_message_is_saved(): void
    {
        $response = $this->post(route('contact.store'), $this->validData());

        $response->assertRedirect(route('home') . '#send-message');
        $response->assertSessionHas('contact_success');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Recruiter Test',
            'email' => 'recruiter@example.com',
        ]);
    }

    public function test_all_fields_are_required(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseEmpty('contact_messages');
    }

    public function test_validation_errors_redirect_back_to_the_form(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertRedirect(route('home') . '#send-message');
    }

    public function test_email_must_be_valid(): void
    {
        $response = $this->post(route('contact.store'), $this->validData([
            'email' => 'not-an-email',
        ]));

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseEmpty('contact_messages');
    }

    public function test_message_must_be_at_least_ten_characters(): void
    {
        $response = $this->post(route('contact.store'), $this->validData([
            'message' => 'hai',
        ]));

        $response->assertSessionHasErrors(['message']);
        $this->assertDatabaseEmpty('contact_messages');
    }

    public function test_honeypot_submissions_look_successful_but_are_not_saved(): void
    {
        $response = $this->post(route('contact.store'), $this->validData([
            'website' => 'http://spam.example',
        ]));

        // Bot "melihat" sukses...
        $response->assertRedirect(route('home') . '#send-message');
        $response->assertSessionHas('contact_success');

        // ...tapi tidak ada yang tersimpan
        $this->assertDatabaseEmpty('contact_messages');
    }

    public function test_contact_form_is_rate_limited_to_five_submissions(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->post(route('contact.store'), $this->validData())
                ->assertSessionHasNoErrors();
        }

        $response = $this->post(route('contact.store'), $this->validData());

        $response->assertSessionHasErrors(['message']);
        $this->assertDatabaseCount('contact_messages', 5);
    }

    public function test_extra_fields_are_not_saved(): void
    {
        $this->post(route('contact.store'), $this->validData([
            'read_at' => now(),
        ]));

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'recruiter@example.com',
            'read_at' => null,
        ]);
    }
}