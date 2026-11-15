@php
    $links = [
        'About' => '#about',
        'Skills' => '#skills',
        'Experience' => '#experience',
        'Work' => '#work',
        'Contact' => '#contact',
        'Mini Game' => '#mini-game',
    ];
@endphp

<header class="sticky top-0 z-50 border-b border-neutral-200/70 bg-white/80 backdrop-blur dark:border-neutral-800/70 dark:bg-neutral-950/80">
    <nav class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4" aria-label="Main navigation">
        <a href="#hero" class="font-serif text-2xl tracking-tight">
            {{ config('portfolio.name') }}<span class="text-accent">.</span>
        </a>

        {{-- Desktop menu --}}
        <ul class="hidden items-center gap-8 text-sm md:flex">
            @foreach ($links as $label => $href)
                <li>
                    <a href="{{ $href }}" class="nav-link text-neutral-600 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-white">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
            <li>
                <a href="#resume" class="rounded-full border border-neutral-300 px-4 py-2 transition-colors hover:border-accent hover:text-accent dark:border-neutral-700">
                    Resume
                </a>
            </li>
        </ul>

        {{-- Mobile menu button --}}
        <button type="button"
                class="rounded-md p-2 md:hidden"
                aria-controls="mobile-menu"
                aria-expanded="false"
                aria-label="Toggle menu"
                data-menu-toggle>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>
    </nav>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden border-t border-neutral-200 md:hidden dark:border-neutral-800" data-menu>
        <ul class="mx-auto flex max-w-5xl flex-col px-6 py-4">
            @foreach ($links as $label => $href)
                <li>
                    <a href="{{ $href }}" class="block py-3 text-lg">{{ $label }}</a>
                </li>
            @endforeach
            <li>
                <a href="#resume" class="block py-3 text-lg text-accent">Resume</a>
            </li>
        </ul>
    </div>
</header>