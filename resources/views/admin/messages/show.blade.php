@extends('layouts.admin')

@section('title', 'Message from ' . $contactMessage->name)

@section('content')
    <main class="mx-auto max-w-3xl px-6 py-10">
        <a href="{{ route('admin.messages.index') }}" class="text-sm text-neutral-500 hover:text-accent">
            ← All messages
        </a>

        <article class="mt-6 rounded-xl border border-neutral-200 bg-white p-6 sm:p-8 dark:border-neutral-800 dark:bg-neutral-900">
            <header class="border-b border-neutral-200 pb-5 dark:border-neutral-800">
                <h1 class="text-2xl font-medium">{{ $contactMessage->name }}</h1>
                <p class="mt-1 break-all text-neutral-600 dark:text-neutral-400">{{ $contactMessage->email }}</p>
                <p class="mt-3 text-xs text-neutral-500">
                    Received
                    <time datetime="{{ $contactMessage->created_at->toIso8601String() }}">
                        {{ $contactMessage->created_at->timezone(config('portfolio.timezone'))->format('d M Y, H:i') }} WIB
                    </time>
                </p>
            </header>

            <div class="mt-6 whitespace-pre-line break-words leading-relaxed text-neutral-800 dark:text-neutral-200">{{ $contactMessage->message }}</div>

                        <footer class="mt-8 flex flex-wrap gap-3">
                <a href="mailto:{{ $contactMessage->email }}?subject={{ rawurlencode('Re: Your message on my portfolio') }}"
                   class="inline-flex items-center rounded-full bg-accent px-5 py-2.5 text-sm font-medium text-neutral-950 transition-opacity hover:opacity-90">
                    Reply via email
                </a>

                <form method="POST"
                      action="{{ route('admin.messages.destroy', $contactMessage) }}"
                      data-confirm="Delete this message permanently? This cannot be undone.">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center rounded-full border border-red-500/50 px-5 py-2.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-500/10 dark:text-red-400">
                        Delete
                    </button>
                </form>
            </footer>
        </article>
    </main>
@endsection