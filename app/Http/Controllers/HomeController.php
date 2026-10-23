<?php

namespace App\Http\Controllers;

use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::ordered()->get();
        $personSchema = $this->personSchema();

        return view('home', compact('projects', 'personSchema'));
    }

    /**
     * Structured data (schema.org Person) untuk mesin pencari.
     * Semua isinya diambil dari config/portfolio.php.
     */
    private function personSchema(): array
    {
        $currentJob = config('portfolio.experience.0');
        $university = config('portfolio.education.0');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => config('portfolio.name'),
            'alternateName' => 'Muhammad Dzuhur',
            'url' => route('home'),
            'jobTitle' => config('portfolio.role'),
            'worksFor' => [
                '@type' => 'Organization',
                'name' => $currentJob['company'],
            ],
            'alumniOf' => [
                '@type' => 'CollegeOrUniversity',
                'name' => $university['school'],
            ],
            'sameAs' => collect(config('portfolio.contact.socials'))->pluck('url')->all(),
        ];
    }
}