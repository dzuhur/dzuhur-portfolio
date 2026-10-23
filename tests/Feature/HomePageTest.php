<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(config('portfolio.name'));
        $response->assertSee(config('portfolio.role'));
    }

    public function test_home_page_shows_projects_from_the_database(): void
    {
        // Arrange
        Project::create([
            'title' => 'My Test Project',
            'slug' => 'my-test-project',
            'category' => 'tech',
            'description' => 'A project created inside a test.',
            'technologies' => ['Laravel', 'Pest'],
        ]);

        // Act
        $response = $this->get('/');

        // Assert
        $response->assertOk();
        $response->assertSee('My Test Project');
        $response->assertSee('Laravel');
    }

    public function test_home_page_shows_empty_state_when_there_are_no_projects(): void
    {
        $response = $this->get('/');

        $response->assertSee('New projects are on the way.');
    }

    public function test_hidden_admin_link_is_not_shown_to_visitors(): void
    {
        $response = $this->get('/');

        $response->assertDontSee('/admin');
    }
}