@php
    $items = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'Messages', 'route' => 'admin.messages.index', 'active' => 'admin.messages.*'],
        ['label' => 'Projects', 'route' => 'admin.projects.index', 'active' => 'admin.projects.*'],
    ];
@endphp

<header class="border-b border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-900">
    <nav class="mx-auto flex max-w-5xl flex-wrap items-center gap-x-8 gap-y-3 px-6 py-4" aria-label="Admin navigation">
        <a href="{{ route('admin.dashboard') }}" class="font-serif text-xl tracking-tight">
            {{ config('portfolio.name') }}<span class="text-accent">.</span>
            <span class="ml-1 align-middle font-sans text-xs uppercase tracking-widest text-neutral-500">Admin</span>
        </a>

        <ul class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm">
            @foreach ($items as $item)
                @if (Route::has($item['route']))
                    <li>
                        <a href="{{ route($item['route']) }}"
                           @class([
                               'transition-colors hover:text-accent',
                               'font-medium text-neutral-900 underline decoration-accent decoration-2 underline-offset-8 dark:text-white' => request()->routeIs($item['active']),
                               'text-neutral-500' => ! request()->routeIs($item['active']),
                           ])
                           @if (request()->routeIs($item['active'])) aria-current="page" @endif>
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

        <div class="ml-auto flex items-center gap-5 text-sm">
            <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
               class="text-neutral-500 transition-colors hover:text-accent">
                View site ↗
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="rounded-full border border-neutral-300 px-4 py-1.5 transition-colors hover:border-accent hover:text-accent dark:border-neutral-700">
                    Log out
                </button>
            </form>
        </div>
    </nav>
</header>