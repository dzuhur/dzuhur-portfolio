@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
    <main class="mx-auto max-w-5xl px-6 py-10">
        <h1 class="text-2xl font-medium">Messages</h1>
        <p class="mt-2 text-sm text-neutral-500">
            {{ $messages->total() }} {{ Str::plural('message', $messages->total()) }} from your contact form. Times in WIB.
        </p>

        <ul class="mt-8 divide-y divide-neutral-200 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:divide-neutral-800 dark:border-neutral-800 dark:bg-neutral-900">
            @forelse ($messages as $contactMessage)
                <li>
                    <a href="{{ route('admin.messages.show', $contactMessage) }}"
                       class="block px-5 py-4 transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                        <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                            <p @class(['flex items-center gap-2', 'font-semibold' => $contactMessage->isUnread()])>
                                @if ($contactMessage->isUnread())
                                    <span class="rounded-full bg-accent px-2 py-0.5 text-xs font-medium text-neutral-950">New</span>
                                @endif
                                {{ $contactMessage->name }}
                                <span class="font-normal text-neutral-500">· {{ $contactMessage->email }}</span>
                            </p>
                            <time datetime="{{ $contactMessage->created_at->toIso8601String() }}" class="text-xs text-neutral-500">
                                {{ $contactMessage->created_at->timezone(config('portfolio.timezone'))->format('d M Y, H:i') }}
                            </time>
                        </div>
                        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                            {{ Str::limit($contactMessage->message, 100) }}
                        </p>
                    </a>
                </li>
            @empty
                <li class="px-5 py-10 text-center text-sm text-neutral-500">
                    No messages yet.
                </li>
            @endforelse
        </ul>

        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    </main>
@endsection