<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
                [
                    'title' => 'Personal Portfolio Website',
                    'slug' => 'personal-portfolio-website',
                    'category' => 'tech',
                    'description' => 'My personal portfolio and resume website, built from scratch with Laravel while learning web development fundamentals.',
                    'technologies' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'Blade'],
                    'live_url' => null,
                    'year' => 2026,
                    'featured' => true,
                ],
                [
                    'title' => 'Chikuro Mobile App',
                    'slug' => 'chikuro-mobile-app',
                    'category' => 'tech',
                    'description' => 'A customer-facing mobile app for Chikuro, currently in development. I planned the development timeline and kicked off the build as part of my IT role.',
                    'technologies' => ['Flutter', 'Laravel'],
                    'live_url' => null,
                    'year' => 2026,
                    'featured' => true,
                ],
                [
                    'title' => "Chikuro's Instagram Content",
                    'slug' => 'chikuro-instagram-content',
                    'category' => 'creative',
                    'description' => 'End-to-end content production for Chikuro\'s Instagram from 2023 to 2026, from content planning and shooting to editing and performance reporting. Grew the account from 6K to 36K followers, with one video reaching 900K views.',
                    'technologies' => ['Content Strategy', 'Video Production', 'Video Editing', 'Reporting'],
                    'live_url' => 'https://drive.google.com/drive/folders/1jNEOpnW0z3sUr7lr8Du5jmNDx6ELZumB?usp=sharing',
                    'year' => 2026,
                    'featured' => true,
                ],
            ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }
    }
}