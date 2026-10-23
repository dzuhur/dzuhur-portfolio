<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Carbon;

class SeoController extends Controller
{
    public function robots()
    {
        $content = implode("\n", [
            'User-agent: *',
            'Disallow: /admin',
            '',
            'Sitemap: ' . route('sitemap'),
        ]);

        return response($content)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function sitemap()
    {
        // Tanggal update terakhir = project yang paling baru diubah
        $latestUpdate = Project::max('updated_at');
        $lastModified = $latestUpdate ? Carbon::parse($latestUpdate) : now();

        return response()
            ->view('sitemap', compact('lastModified'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}