<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        Storage::fake('public');
    }

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Brand Campaign',
            'category' => 'creative',
            'description' => 'A campaign created inside a test.',
            'technologies_input' => 'Content Strategy, Video Editing',
            'year' => 2026,
            'sort_order' => 10,
        ], $overrides);
    }

    private function fakeImage(string $name = 'thumbnail.jpg', int $kilobytes = 100): UploadedFile
    {
        return UploadedFile::fake()->create($name, $kilobytes, 'image/jpeg');
    }

        private function createProjectWithImage(): Project
    {
        $this->actingAs($this->admin)->post(
            route('admin.projects.store'),
            $this->validData(['image' => $this->fakeImage()])
        );

        return Project::first();
    }

    /**
     * Disk storage palsu (dari Storage::fake). ...
     *
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    private function disk()
    {
        return Storage::disk('public');
    }

    // ── Tambah project ─────────────────────────────────────────────

    // ── Tambah project ─────────────────────────────────────────────

    public function test_admin_can_create_a_project(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), $this->validData([
            'technologies_input' => 'Laravel, , Tailwind CSS, Laravel',
            'featured' => '1',
        ]));

        $response->assertRedirect(route('admin.projects.index'));
        $response->assertSessionHasNoErrors();

        $project = Project::first();
        $this->assertSame('brand-campaign', $project->slug);
        $this->assertSame(['Laravel', 'Tailwind CSS'], $project->technologies);
        $this->assertTrue($project->featured);
        $this->assertSame(10, $project->sort_order);
    }

    public function test_unchecked_featured_is_saved_as_false(): void
    {
        $this->actingAs($this->admin)->post(route('admin.projects.store'), $this->validData());

        $this->assertFalse(Project::first()->featured);
    }

    public function test_duplicate_titles_get_unique_slugs(): void
    {
        $this->actingAs($this->admin)->post(route('admin.projects.store'), $this->validData());
        $this->actingAs($this->admin)->post(route('admin.projects.store'), $this->validData());

        $this->assertSame(
            ['brand-campaign', 'brand-campaign-2'],
            Project::orderBy('id')->pluck('slug')->all()
        );
    }

    public function test_links_must_start_with_http_or_https(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), $this->validData([
            'live_url' => 'javascript:alert(1)',
        ]));

        $response->assertSessionHasErrors(['live_url']);
        $this->assertDatabaseEmpty('projects');
    }

    // ── Upload thumbnail ───────────────────────────────────────────

    public function test_admin_can_upload_a_thumbnail_with_a_random_file_name(): void
    {
        $this->actingAs($this->admin)->post(route('admin.projects.store'), $this->validData([
            'image' => $this->fakeImage('my-private-photo.jpg'),
        ]));

        $project = Project::first();

        $this->assertNotNull($project->image);
        $this->assertStringStartsWith('projects/', $project->image);
        $this->assertStringNotContainsString('my-private-photo', $project->image);
        $this->disk()->assertExists($project->image);
    }

    public function test_non_image_files_are_rejected(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), $this->validData([
            'image' => UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
        ]));

        $response->assertSessionHasErrors(['image']);
        $this->assertDatabaseEmpty('projects');
    }

    public function test_svg_files_are_rejected(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), $this->validData([
            'image' => UploadedFile::fake()->create('logo.svg', 10, 'image/svg+xml'),
        ]));

        $response->assertSessionHasErrors(['image']);
        $this->assertDatabaseEmpty('projects');
    }

    public function test_images_larger_than_two_megabytes_are_rejected(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), $this->validData([
            'image' => $this->fakeImage('huge.jpg', 3000),
        ]));

        $response->assertSessionHasErrors(['image']);
        $this->assertDatabaseEmpty('projects');
    }

    // ── Edit project ───────────────────────────────────────────────

    public function test_changing_the_title_updates_the_slug(): void
    {
        $project = $this->createProjectWithImage();

        $this->actingAs($this->admin)->put(
            route('admin.projects.update', $project),
            $this->validData(['title' => 'New Title'])
        )->assertRedirect(route('admin.projects.index'));

        $this->assertSame('new-title', $project->fresh()->slug);
    }

    public function test_keeping_the_title_keeps_the_slug(): void
    {
        $project = $this->createProjectWithImage();

        $this->actingAs($this->admin)->put(
            route('admin.projects.update', $project),
            $this->validData(['description' => 'Only the description changed.'])
        );

        $this->assertSame('brand-campaign', $project->fresh()->slug);
    }

    public function test_updating_without_a_new_image_keeps_the_old_one(): void
    {
        $project = $this->createProjectWithImage();
        $oldImage = $project->image;

        $this->actingAs($this->admin)->put(
            route('admin.projects.update', $project),
            $this->validData(['title' => 'Only The Title Changed'])
        );

        $this->assertSame($oldImage, $project->fresh()->image);
        $this->disk()->assertExists($oldImage);
    }

    public function test_replacing_the_image_deletes_the_old_file(): void
    {
        $project = $this->createProjectWithImage();
        $oldImage = $project->image;

        $this->actingAs($this->admin)->put(
            route('admin.projects.update', $project),
            $this->validData(['image' => $this->fakeImage('new-thumbnail.jpg')])
        );

        $newImage = $project->fresh()->image;

        $this->assertNotSame($oldImage, $newImage);
        $this->disk()->assertMissing($oldImage);
        $this->disk()->assertExists($newImage);
    }

    // ── Hapus project ──────────────────────────────────────────────

    public function test_deleting_a_project_also_deletes_its_image(): void
    {
        $project = $this->createProjectWithImage();
        $image = $project->image;

        $this->actingAs($this->admin)
            ->delete(route('admin.projects.destroy', $project))
            ->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        $this->disk()->assertMissing($image);
    }

    // ── Urutan tampil ──────────────────────────────────────────────

    public function test_display_order_controls_the_order_on_the_website(): void
    {
        Project::create([
            'title' => 'Shown Second',
            'slug' => 'shown-second',
            'category' => 'tech',
            'description' => 'Has a higher sort order.',
            'sort_order' => 20,
        ]);

        Project::create([
            'title' => 'Shown First',
            'slug' => 'shown-first',
            'category' => 'tech',
            'description' => 'Has a lower sort order.',
            'sort_order' => 10,
        ]);

        $this->get('/')->assertSeeInOrder(['Shown First', 'Shown Second']);
    }
}