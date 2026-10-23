@extends('layouts.app')
@push('head')
    <script type="application/ld+json">@json($personSchema)</script>
@endpush
@section('content')
    <main id="main">

        {{-- HERO --}}
        <section id="hero" class="flex min-h-[85svh] items-center">
            <div class="mx-auto w-full max-w-5xl px-6 py-24">
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-accent">
                    {{ config('portfolio.hero.eyebrow') }}
                </p>

                <h1 class="mt-6 font-serif text-7xl leading-none tracking-tight sm:text-8xl lg:text-9xl">
                    {{ config('portfolio.name') }}<span class="text-accent">.</span>
                </h1>

                <p class="mt-8 max-w-3xl text-2xl leading-snug sm:text-3xl">
                    {{ config('portfolio.hero.lead') }}
                    <span class="font-serif italic">{{ config('portfolio.role') }}</span>.
                </p>

                <p class="mt-6 max-w-xl text-base leading-relaxed text-neutral-600 sm:text-lg dark:text-neutral-400">
                    {{ config('portfolio.hero.subheadline') }}
                </p>

                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <a href="#work"
                       class="inline-flex items-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-neutral-950 transition-opacity hover:opacity-90 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent">
                        View My Work
                    </a>

                    <a href="{{ route('resume.download') }}"
                       class="inline-flex items-center rounded-full border border-neutral-300 px-6 py-3 text-sm font-medium transition-colors hover:border-accent hover:text-accent focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent dark:border-neutral-700">
                        Download Resume
                    </a>

                    <a href="#contact"
                       class="px-2 py-3 text-sm font-medium underline-offset-4 hover:text-accent hover:underline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent">
                        Let's Connect →
                    </a>
                </div>
            </div>
        </section>

                {{-- ABOUT --}}
        <section id="about" class="border-t border-neutral-200 dark:border-neutral-800">
            <div class="mx-auto grid max-w-5xl gap-10 px-6 py-24 md:grid-cols-[1fr_2fr] md:gap-16">
                <x-section-heading number="01" title="About" />

                <div class="space-y-6 text-lg leading-relaxed text-neutral-700 dark:text-neutral-300">
                    @foreach (config('portfolio.about') as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- SKILLS --}}
        <section id="skills" class="border-t border-neutral-200 dark:border-neutral-800">
            <div class="mx-auto grid max-w-5xl gap-10 px-6 py-24 md:grid-cols-[1fr_2fr] md:gap-16">
                <x-section-heading number="02" title="Skills" />

                <div class="space-y-12">
                    @foreach (config('portfolio.skills') as $group)
                        <div>
                            <div class="flex flex-wrap items-baseline justify-between gap-2 border-b border-neutral-200 pb-3 dark:border-neutral-800">
                                <h3 class="text-xl font-medium">{{ $group['group'] }}</h3>
                                <p class="text-sm text-neutral-500">{{ $group['label'] }}</p>
                            </div>

                            <ul class="mt-4 flex flex-wrap gap-2">
                                @foreach ($group['items'] as $item)
                                    <li class="rounded-full border border-neutral-300 px-3 py-1 text-sm text-neutral-700 dark:border-neutral-700 dark:text-neutral-300">
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

                {{-- EXPERIENCE --}}
        <section id="experience" class="border-t border-neutral-200 dark:border-neutral-800">
            <div class="mx-auto grid max-w-5xl gap-10 px-6 py-24 md:grid-cols-[1fr_2fr] md:gap-16">
                <x-section-heading number="03" title="Experience" />

                <div>
                    {{-- Timeline --}}
                    <ol class="space-y-14 border-l border-neutral-200 pl-8 dark:border-neutral-800">
                        @foreach (config('portfolio.experience') as $job)
                            <li class="relative">
                                <span @class([
                                    'absolute -left-[37.5px] top-1.5 h-2.5 w-2.5 rounded-full ring-4 ring-white dark:ring-neutral-950',
                                    'bg-accent' => $loop->first,
                                    'bg-neutral-400 dark:bg-neutral-600' => ! $loop->first,
                                ]) aria-hidden="true"></span>

                                <p class="text-sm text-neutral-500">{{ $job['period'] }}</p>
                                <h3 class="mt-1 text-xl font-medium">{{ $job['title'] }}</h3>
                                <p class="text-neutral-600 dark:text-neutral-400">{{ $job['company'] }}</p>

                                @if (! empty($job['note']))
                                    <p class="mt-2 text-sm italic text-neutral-500">{{ $job['note'] }}</p>
                                @endif

                                <ul class="mt-4 list-disc space-y-1.5 pl-5 text-neutral-700 marker:text-neutral-400 dark:text-neutral-300">
                                    @foreach ($job['points'] as $point)
                                        <li>{{ $point }}</li>
                                    @endforeach
                                </ul>

                                @if (! empty($job['highlights']))
                                    <div class="mt-6 flex flex-wrap gap-3">
                                        @foreach ($job['highlights'] as $highlight)
                                            <div class="rounded-lg border border-accent/30 bg-accent/5 px-5 py-4">
                                                <p class="font-serif text-3xl text-accent">{{ $highlight['value'] }}</p>
                                                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">{{ $highlight['label'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ol>

                    {{-- Education --}}
                    <div class="mt-20">
                        <h3 class="border-b border-neutral-200 pb-3 text-xl font-medium dark:border-neutral-800">Education</h3>

                        <ul class="mt-6 space-y-6">
                            @foreach (config('portfolio.education') as $edu)
                                <li class="grid gap-1 sm:grid-cols-[1fr_auto] sm:gap-6">
                                    <div>
                                        <p class="font-medium">{{ $edu['degree'] }}</p>
                                        <p class="text-neutral-600 dark:text-neutral-400">{{ $edu['school'] }}</p>

                                        @if (! empty($edu['note']))
                                            <p class="mt-1 text-sm italic text-neutral-500">{{ $edu['note'] }}</p>
                                        @endif
                                    </div>
                                    <p class="text-sm text-neutral-500 sm:text-right">{{ $edu['year'] }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

                {{-- WORK --}}
        <section id="work" class="border-t border-neutral-200 dark:border-neutral-800">
            <div class="mx-auto max-w-5xl px-6 py-24">
                <x-section-heading number="04" title="Selected Work" :sticky="false" />

                <ul class="mt-12 grid gap-6 md:grid-cols-2">
                    @forelse ($projects as $project)
                        <li>
                            <article class="flex h-full flex-col overflow-hidden rounded-xl border border-neutral-200 transition-colors hover:border-neutral-400 dark:border-neutral-800 dark:hover:border-neutral-600">

                                {{-- Thumbnail atau placeholder tipografi --}}
                                @if ($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}"
                                         alt="{{ $project->title }}"
                                         class="aspect-[16/10] w-full object-cover"
                                         loading="lazy">
                                @else
                                    <div class="flex aspect-[16/10] items-end bg-neutral-100 p-6 dark:bg-neutral-900" aria-hidden="true">
                                        <span class="font-serif text-5xl italic text-neutral-300 dark:text-neutral-700">
                                            {{ ucfirst($project->category) }}
                                        </span>
                                    </div>
                                @endif

                                <div class="flex flex-1 flex-col p-6">
                                    <div class="flex items-center justify-between gap-4 text-sm">
                                        <span class="font-medium uppercase tracking-[0.15em] text-accent">{{ $project->category }}</span>
                                        @if ($project->year)
                                            <span class="text-neutral-500">{{ $project->year }}</span>
                                        @endif
                                    </div>

                                    <h3 class="mt-3 text-xl font-medium">{{ $project->title }}</h3>

                                    <p class="mt-3 leading-relaxed text-neutral-600 dark:text-neutral-400">
                                        {{ $project->description }}
                                    </p>

                                    @if (! empty($project->technologies))
                                        <ul class="mt-5 flex flex-wrap gap-2" aria-label="Technologies">
                                            @foreach ($project->technologies as $tech)
                                                <li class="rounded-full bg-neutral-100 px-3 py-1 text-xs text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300">
                                                    {{ $tech }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if ($project->live_url || $project->github_url)
                                        <div class="mt-auto flex flex-wrap gap-x-6 gap-y-2 pt-6 text-sm font-medium">
                                            @if ($project->live_url)
                                                <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer"
                                                   class="underline-offset-4 hover:text-accent hover:underline">
                                                    View project ↗
                                                </a>
                                            @endif
                                            @if ($project->github_url)
                                                <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                                   class="underline-offset-4 hover:text-accent hover:underline">
                                                    Source code ↗
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </article>
                        </li>
                    @empty
                        <li class="rounded-xl border border-dashed border-neutral-300 p-10 text-center text-neutral-500 md:col-span-2 dark:border-neutral-700">
                            New projects are on the way.
                        </li>
                    @endforelse
                </ul>
            </div>
        </section>

                {{-- RESUME --}}
        <section id="resume" class="border-t border-neutral-200 dark:border-neutral-800">
            <div class="mx-auto grid max-w-5xl gap-10 px-6 py-24 md:grid-cols-[1fr_2fr] md:gap-16">
                <x-section-heading number="05" title="Resume" />

                <div>
                    <p class="max-w-xl text-lg leading-relaxed text-neutral-700 dark:text-neutral-300">
                        A one-page summary of my experience, skills, and education — in a format that's easy to save and share.
                    </p>

                    @if (session('resume_missing'))
                        <p role="status" class="mt-6 max-w-xl rounded-lg border border-accent/30 bg-accent/5 px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">
                            My resume is being updated right now. Please check back soon, or reach out through the contact form below.
                        </p>
                    @endif

                    <a href="{{ route('resume.download') }}"
                       class="mt-8 inline-flex items-center gap-3 rounded-full bg-accent px-6 py-3 text-sm font-medium text-neutral-950 transition-opacity hover:opacity-90 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent">
                        Download CV
                        <span class="text-xs opacity-70">PDF</span>
                    </a>
                </div>
            </div>
        </section>

                {{-- CONTACT --}}
        <section id="contact" class="border-t border-neutral-200 dark:border-neutral-800">
            <div class="mx-auto grid max-w-5xl gap-10 px-6 py-24 md:grid-cols-[1fr_2fr] md:gap-16">
                <x-section-heading number="06" title="Contact" />

                <div>
                    <p class="max-w-xl font-serif text-3xl leading-snug sm:text-4xl">
                        Have a role, a project, or an idea in mind?
                        <span class="italic text-accent">Let's talk.</span>
                    </p>

                    <address class="mt-10 not-italic">
                        <p class="text-sm uppercase tracking-[0.15em] text-neutral-500">Email</p>
                        <a href="mailto:{{ config('portfolio.contact.email') }}"
                           class="mt-2 inline-block break-all text-xl underline decoration-neutral-300 underline-offset-8 transition-colors hover:text-accent hover:decoration-accent sm:text-2xl dark:decoration-neutral-700">
                            {{ config('portfolio.contact.email') }}
                        </a>

                        <ul class="mt-10 divide-y divide-neutral-200 border-y border-neutral-200 dark:divide-neutral-800 dark:border-neutral-800">
                            @foreach (config('portfolio.contact.socials') as $social)
                                <li>
                                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                                       class="group flex items-center justify-between gap-4 py-4 transition-colors hover:text-accent">
                                        <span class="font-medium">{{ $social['label'] }}</span>
                                        <span class="text-neutral-500 transition-colors group-hover:text-accent">
                                            {{ $social['handle'] }} ↗
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </address>

                                        {{-- Contact form --}}
                        <div id="send-message" class="mt-16">
                        <h3 class="text-xl font-medium">Send a message</h3>

                        @if (session('contact_success'))
                            <p role="status" class="mt-6 rounded-lg border border-accent/30 bg-accent/5 px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">
                                Thanks for reaching out! Your message has been received, and I'll get back to you soon.
                            </p>
                        @endif

                            <form method="POST" action="{{ route('contact.store') }}" class="relative mt-6 space-y-5" novalidate data-contact-form>
                            @csrf

                            {{-- Honeypot: disembunyikan dari manusia, hanya bot yang mengisi --}}
                            <div class="absolute -left-[10000px] h-px w-px overflow-hidden" aria-hidden="true">
                                <label for="website">Website</label>
                                <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                            </div>

                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-medium">Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}"
                                       required maxlength="100" autocomplete="name"
                                       @class([
                                           'mt-2 block w-full rounded-lg border bg-transparent px-4 py-3 outline-none transition-colors focus:border-accent',
                                           'border-red-500' => $errors->has('name'),
                                           'border-neutral-300 dark:border-neutral-700' => ! $errors->has('name'),
                                       ])
                                       @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                                @error('name')
                                    <p id="name-error" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                       required maxlength="255" autocomplete="email"
                                       @class([
                                           'mt-2 block w-full rounded-lg border bg-transparent px-4 py-3 outline-none transition-colors focus:border-accent',
                                           'border-red-500' => $errors->has('email'),
                                           'border-neutral-300 dark:border-neutral-700' => ! $errors->has('email'),
                                       ])
                                       @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                                @error('email')
                                    <p id="email-error" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Message --}}
                            <div>
                                <label for="message" class="block text-sm font-medium">Message</label>
                                <textarea id="message" name="message" rows="5"
                                          required minlength="10" maxlength="2000"
                                          @class([
                                              'mt-2 block w-full resize-y rounded-lg border bg-transparent px-4 py-3 outline-none transition-colors focus:border-accent',
                                              'border-red-500' => $errors->has('message'),
                                              'border-neutral-300 dark:border-neutral-700' => ! $errors->has('message'),
                                          ])
                                          @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>
                                @error('message')
                                    <p id="message-error" class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" data-submit-button
                                    class="inline-flex items-center rounded-full bg-accent px-6 py-3 text-sm font-medium text-neutral-950 transition-opacity hover:opacity-90 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent disabled:cursor-not-allowed disabled:opacity-60">
                                Send message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection