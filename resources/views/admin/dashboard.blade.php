@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <main class="mx-auto max-w-5xl px-6 py-10">
        <h1 class="text-2xl font-medium">Dashboard</h1>
        <p class="mt-2 text-neutral-600 dark:text-neutral-400">
            Welcome back, {{ auth()->user()->name }}.
        </p>

        {{-- Visitors --}}
        <section class="mt-10" aria-labelledby="visitors-heading">
            <div class="flex flex-wrap items-baseline justify-between gap-2">
                <h2 id="visitors-heading" class="text-lg font-medium">Visitors</h2>
                <p class="text-xs text-neutral-500">Times in WIB · unique visitors reset daily for privacy</p>
            </div>

            <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($visitorStats as $label => $stat)
                    <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                        <p class="text-sm text-neutral-500">{{ $label }}</p>
                        <p class="mt-2 text-4xl font-medium tabular-nums">{{ number_format($stat['unique']) }}</p>
                        <p class="mt-1 text-xs text-neutral-500">
                            unique · {{ number_format($stat['views']) }} page views
                        </p>
                    </div>
                @endforeach
            </div>
        </section>

                {{-- Other numbers --}}
        <section class="mt-10" aria-labelledby="overview-heading">
            <h2 id="overview-heading" class="text-lg font-medium">Overview</h2>

            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                    <p class="text-sm text-neutral-500">CV downloads</p>
                    <p class="mt-2 text-4xl font-medium tabular-nums">{{ number_format($resumeDownloads) }}</p>
                </div>

                <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-800 dark:bg-neutral-900">
                    <p class="text-sm text-neutral-500">Projects</p>
                    <p class="mt-2 text-4xl font-medium tabular-nums">{{ number_format($projectCount) }}</p>
                </div>

                <a href="{{ route('admin.messages.index') }}"
                   class="block rounded-xl border border-neutral-200 bg-white p-5 transition-colors hover:border-accent dark:border-neutral-800 dark:bg-neutral-900">
                    <p class="text-sm text-neutral-500">Messages</p>
                    <p class="mt-2 text-4xl font-medium tabular-nums">{{ number_format($messageCount) }}</p>
                    @if ($unreadCount > 0)
                        <p class="mt-1 text-xs font-medium text-accent">{{ $unreadCount }} unread</p>
                    @endif
                </a>
            </div>
        </section>

        {{-- Top referrers --}}
        <section class="mt-10" aria-labelledby="referrers-heading">
            <h2 id="referrers-heading" class="text-lg font-medium">Top sources this month</h2>

            <ul class="mt-4 divide-y divide-neutral-200 rounded-xl border border-neutral-200 bg-white dark:divide-neutral-800 dark:border-neutral-800 dark:bg-neutral-900">
                @forelse ($topReferrers as $referrer)
                    <li class="flex items-center justify-between gap-4 px-5 py-3 text-sm">
                        <span class="truncate">{{ $referrer->referer }}</span>
                        <span class="text-neutral-500">{{ number_format($referrer->total) }}</span>
                    </li>
                @empty
                    <li class="px-5 py-6 text-center text-sm text-neutral-500">
                        No external sources yet. Most visits so far are direct.
                    </li>
                @endforelse
            </ul>
        </section>
    </main>
@endsection