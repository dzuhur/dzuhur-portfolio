@extends('layouts.admin')

@section('title', 'Log in')

@section('content')
    <main class="flex min-h-screen items-center justify-center px-6 py-12">
        <div class="w-full max-w-sm">
            <a href="{{ route('home') }}" class="font-serif text-3xl tracking-tight">
                {{ config('portfolio.name') }}<span class="text-accent">.</span>
            </a>

            <h1 class="mt-8 text-2xl font-medium">Admin login</h1>

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5" novalidate>
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           @class([
                               'mt-2 block w-full rounded-lg border bg-white px-4 py-3 outline-none transition-colors focus:border-accent dark:bg-neutral-900',
                               'border-red-500' => $errors->has('email'),
                               'border-neutral-300 dark:border-neutral-700' => ! $errors->has('email'),
                           ])
                           @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                    @error('email')
                        <p id="email-error" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input id="password" name="password" type="password"
                           required autocomplete="current-password"
                           class="mt-2 block w-full rounded-lg border border-neutral-300 bg-white px-4 py-3 outline-none transition-colors focus:border-accent dark:border-neutral-700 dark:bg-neutral-900">
                </div>

                <button type="submit"
                        class="w-full rounded-full bg-accent px-6 py-3 text-sm font-medium text-neutral-950 transition-opacity hover:opacity-90 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent">
                    Log in
                </button>
            </form>

            <a href="{{ route('home') }}" class="mt-8 inline-block text-sm text-neutral-500 hover:text-accent">
                ← Back to website
            </a>
        </div>
    </main>
@endsection