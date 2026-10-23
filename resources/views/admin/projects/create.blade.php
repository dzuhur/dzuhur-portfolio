@extends('layouts.admin')

@section('title', 'New project')

@section('content')
    <main class="mx-auto max-w-3xl px-6 py-10">
        <a href="{{ route('admin.projects.index') }}" class="text-sm text-neutral-500 hover:text-accent">← All projects</a>
        <h1 class="mt-4 text-2xl font-medium">New project</h1>

        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="mt-8" novalidate>
            @csrf
            @include('admin.projects._form', ['submitLabel' => 'Create project'])
        </form>
    </main>
@endsection