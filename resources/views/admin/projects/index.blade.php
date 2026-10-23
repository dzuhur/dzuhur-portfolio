@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
    <main class="mx-auto max-w-5xl px-6 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-medium">Projects</h1>
                <p class="mt-2 text-sm text-neutral-500">
                    {{ $projects->count() }} {{ Str::plural('project', $projects->count()) }}, in the same order as on your website.
                </p>
            </div>

            @if (Route::has('admin.projects.create'))
                <a href="{{ route('admin.projects.create') }}"
                   class="inline-flex items-center rounded-full bg-accent px-5 py-2.5 text-sm font-medium text-neutral-950 transition-opacity hover:opacity-90">
                    + New project
                </a>
            @endif
        </div>

        <ul class="mt-8 divide-y divide-neutral-200 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:divide-neutral-800 dark:border-neutral-800 dark:bg-neutral-900">
            @forelse ($projects as $project)
                <li class="flex flex-wrap items-center gap-x-4 gap-y-2 px-5 py-4">
                    <div class="min-w-0 flex-1">
                        <p class="flex flex-wrap items-center gap-2 font-medium">
                            {{ $project->title }}
                            @if ($project->featured)
                                <span class="rounded-full border border-accent/40 px-2 py-0.5 text-xs font-normal text-accent">Featured</span>
                            @endif
                        </p>
                        <p class="mt-1 text-sm text-neutral-500">
                            Order {{ $project->sort_order }} · {{ ucfirst($project->category) }}
                            @if ($project->year) · {{ $project->year }} @endif
                            · {{ $project->image ? 'Has thumbnail' : 'No thumbnail' }}
                        </p>
                    </div>

                    @if (Route::has('admin.projects.edit'))
                        <a href="{{ route('admin.projects.edit', $project) }}"
                           class="text-sm text-neutral-500 transition-colors hover:text-accent">
                            Edit
                        </a>
                    @endif
                </li>
            @empty
                <li class="px-5 py-10 text-center text-sm text-neutral-500">
                    No projects yet.
                </li>
            @endforelse
        </ul>
    </main>
@endsection