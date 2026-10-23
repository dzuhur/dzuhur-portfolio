<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    private function createProject(): Project
    {
        return Project::create([
            'title' => 'Real Project',
            'slug' => 'real-project',
            'category' => 'tech',
            'description' => 'A real project that must not be changed by guests.',
        ]);
    }

    private function createMessage(): ContactMessage
    {
        return ContactMessage::create([
            'name' => 'Recruiter',
            'email' => 'recruiter@example.com',
            'message' => 'A private message that guests must not see.',
        ]);
    }

    /**
     * Membaca SEMUA route aplikasi. Setiap route area admin
     * (kecuali halaman login) wajib memakai middleware auth.
     */
    public function test_every_admin_route_requires_authentication(): void
    {
        $publicAdminRoutes = ['login', 'login.store'];

        $adminRoutes = collect(Route::getRoutes()->getRoutes())->filter(
            fn ($route) => str_starts_with($route->uri(), 'admin')
                || str_starts_with((string) $route->getName(), 'admin.')
        );

        $this->assertNotEmpty($adminRoutes, 'No admin routes were found.');

        foreach ($adminRoutes as $route) {
            if (in_array($route->getName(), $publicAdminRoutes, true)) {
                continue;
            }

            $this->assertContains(
                'auth',
                $route->gatherMiddleware(),
                "Route [{$route->uri()}] is missing the auth middleware."
            );
        }
    }

    public function test_guests_are_redirected_to_login_from_admin_pages(): void
    {
        $project = $this->createProject();
        $message = $this->createMessage();

        $urls = [
            route('admin.dashboard'),
            route('admin.messages.index'),
            route('admin.messages.show', $message),
            route('admin.projects.index'),
            route('admin.projects.create'),
            route('admin.projects.edit', $project),
        ];

        foreach ($urls as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }
    }

    public function test_guests_cannot_create_update_or_delete_anything(): void
    {
        $project = $this->createProject();
        $message = $this->createMessage();

        $this->post(route('admin.projects.store'), [
            'title' => 'Hacked Project',
            'category' => 'tech',
            'description' => 'Should never be saved.',
        ])->assertRedirect(route('login'));

        $this->put(route('admin.projects.update', $project), [
            'title' => 'Hacked Title',
            'category' => 'tech',
            'description' => 'Should never be saved.',
        ])->assertRedirect(route('login'));

        $this->delete(route('admin.projects.destroy', $project))->assertRedirect(route('login'));
        $this->delete(route('admin.messages.destroy', $message))->assertRedirect(route('login'));

        // Semua data harus tetap utuh
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'title' => 'Real Project']);
        $this->assertDatabaseHas('contact_messages', ['id' => $message->id]);
        $this->assertDatabaseMissing('projects', ['title' => 'Hacked Project']);
    }

    public function test_guests_cannot_see_private_message_content(): void
    {
        $message = $this->createMessage();

        $this->get(route('admin.messages.show', $message))
            ->assertDontSee('A private message that guests must not see.');
    }

    public function test_logged_in_admin_can_open_all_admin_pages(): void
    {
        $admin = User::factory()->create();
        $project = $this->createProject();
        $message = $this->createMessage();

        $urls = [
            route('admin.dashboard'),
            route('admin.messages.index'),
            route('admin.messages.show', $message),
            route('admin.projects.index'),
            route('admin.projects.create'),
            route('admin.projects.edit', $project),
        ];

        foreach ($urls as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    public function test_logged_in_admin_is_sent_to_dashboard_from_login_page(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('login'))
            ->assertRedirect(route('admin.dashboard'));
    }
}