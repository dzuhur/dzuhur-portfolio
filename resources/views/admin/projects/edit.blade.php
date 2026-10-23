@extends('layouts.admin')

@section('title', 'Edit ' . $project->title)

@section('content')
    <main class="mx-auto max-w-3xl px-6 py-10">
        <a href="{{ route('admin.projects.index') }}" class="text-sm text-neutral-500 hover:text-accent">← All projects</a>
        <h1 class="mt-4 text-2xl font-medium">Edit project</h1>
        <p class="mt-1 text-sm text-neutral-500">{{ $project->title }}</p>

        {{-- Form edit --}}
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="mt-8" novalidate>
            @csrf
            @method('PUT')
            @include('admin.projects._form', ['submitLabel' => 'Save changes'])
        </form>

        {{-- Danger zone: form terpisah, BUKAN di dalam form edit --}}
        <section class="mt-16 rounded-xl border border-red-500/40 p-6" aria-labelledby="danger-heading">
            <h2 id="danger-heading" class="font-medium text-red-600 dark:text-red-400">Danger zone</h2>
            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                Deleting this project removes it from your website and deletes its thumbnail. This cannot be undone.
            </p>

            <form method="POST"
                  action="{{ route('admin.projects.destroy', $project) }}"
                  data-confirm="Delete “{{ $project->title }}” permanently? This cannot be undone."
                  class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center rounded-full border border-red-500/50 px-5 py-2.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-500/10 dark:text-red-400">
                    Delete project
                </button>
            </form>
        </section>
    </main>
@endsection