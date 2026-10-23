<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
        public function __invoke()
    {
        $path = config('portfolio.resume.path');

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            Log::warning('Resume download requested, but the file is missing.', ['path' => $path]);

            return redirect()->to(route('home') . '#resume')
                ->with('resume_missing', true);
        }

        return $disk->download($path, config('portfolio.resume.download_name'));
    }
}