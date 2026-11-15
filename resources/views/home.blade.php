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
                                    <div class="project-image overflow-hidden">
                                        <img src="{{ asset('storage/' . $project->image) }}"
                                             alt="{{ $project->title }}"
                                             class="aspect-[16/10] w-full object-cover"
                                             loading="lazy">
                                    </div>
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

{{-- MINI GAME --}}
        <section id="mini-game" class="border-t border-neutral-200 dark:border-neutral-800">
            <div class="mx-auto grid max-w-5xl gap-10 px-6 py-24 md:grid-cols-[1fr_2fr] md:gap-16">
                <x-section-heading number="05" title="Mini Game" />

                <div data-game-shell>
                    <p data-game-intro class="max-w-xl text-lg leading-relaxed text-neutral-700 dark:text-neutral-300">
                        Ikuti penanda kristal untuk mengumpulkan energi. Selesaikan misi kristal lalu aktifkan portal ke biome berikutnya. Penjaga bisa dikalahkan dengan Dash atau tombol E saat berada dekat.
                    </p>

                    <div data-game-hud class="mt-6 grid grid-cols-2 gap-2 text-sm sm:grid-cols-5">
                        <p class="rounded-lg border border-neutral-200 px-3 py-2 dark:border-neutral-800">Skor <span class="ml-1 font-semibold tabular-nums text-accent" data-game-score aria-live="polite">0</span></p>
                        <p class="rounded-lg border border-neutral-200 px-3 py-2 dark:border-neutral-800">Waktu <span class="ml-1 font-medium tabular-nums" data-game-time>00:00</span></p>
                        <p class="rounded-lg border border-neutral-200 px-3 py-2 dark:border-neutral-800">Level <span class="ml-1 font-semibold text-accent" data-game-level>1</span></p>
                        <p class="rounded-lg border border-neutral-200 px-3 py-2 dark:border-neutral-800">HP <span class="ml-1 font-semibold tracking-wider text-rose-500" data-game-hp aria-label="3 nyawa">♥♥♥</span></p>
                        <p class="rounded-lg border border-neutral-200 px-3 py-2 text-neutral-500 dark:border-neutral-800" data-game-best>Terbaik: 0</p>
                    </div>

                    <div data-game-meta class="mt-2 grid grid-cols-2 gap-2 text-xs sm:grid-cols-3">
                        <p class="rounded-lg border border-neutral-200 px-3 py-2 dark:border-neutral-800">Combo <span class="ml-1 font-semibold text-amber-500" data-game-combo>×1</span></p>
                        <p class="rounded-lg border border-neutral-200 px-3 py-2 dark:border-neutral-800">Misi <span class="ml-1 font-medium" data-game-mission>Ambil 3 pecahan</span></p>
                        <p class="rounded-lg border border-neutral-200 px-3 py-2 dark:border-neutral-800">Dash <span class="ml-1 font-semibold text-cyan-500" data-game-dash>Siap</span></p>
                    </div>

                    <div data-game-overdrive-panel class="mt-3 rounded-xl border border-fuchsia-500/30 bg-fuchsia-500/5 p-3">
                        <div class="mb-2 flex items-center justify-between text-xs">
                            <span class="font-semibold uppercase tracking-[.18em] text-fuchsia-600 dark:text-fuchsia-300">Overdrive</span>
                            <span data-game-overdrive-label>Energi 0%</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-neutral-200 dark:bg-neutral-800" role="progressbar" aria-label="Energi Overdrive" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-game-overdrive-bar>
                            <div class="h-full w-0 rounded-full bg-gradient-to-r from-fuchsia-500 via-violet-500 to-cyan-300 shadow-[0_0_12px_rgba(217,70,239,.7)] transition-[width] duration-150" data-game-overdrive-fill></div>
                        </div>
                    </div>

                    <div data-game-tools class="mt-3 flex flex-wrap items-center gap-3">
                        <button type="button" data-game-pause class="rounded-full border border-neutral-300 px-4 py-2 text-sm transition hover:border-accent disabled:cursor-not-allowed disabled:opacity-40 dark:border-neutral-700" disabled>Jeda (P)</button>
                        <button type="button" data-game-fullscreen class="rounded-full border border-neutral-300 px-4 py-2 text-sm transition hover:border-accent focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent dark:border-neutral-700" aria-pressed="false">Fullscreen (F)</button>
                        <details class="group rounded-xl border border-neutral-200 px-4 py-2 text-sm dark:border-neutral-800">
                            <summary class="cursor-pointer font-medium">Pengaturan audio</summary>
                            <div class="mt-3 grid gap-3 pb-1 sm:grid-cols-2">
                                <label class="grid gap-1 text-xs">Musik <span data-game-music-value>35%</span>
                                    <input type="range" min="0" max="100" value="35" data-game-music-volume class="accent-fuchsia-500">
                                </label>
                                <label class="grid gap-1 text-xs">Efek suara <span data-game-sfx-value>70%</span>
                                    <input type="range" min="0" max="100" value="70" data-game-sfx-volume class="accent-cyan-500">
                                </label>
                            </div>
                        </details>
                    </div>

                    <div data-game-board class="relative mt-5 h-64 touch-none overflow-hidden rounded-xl border border-cyan-500/40 bg-neutral-950 outline-none focus-visible:ring-2 focus-visible:ring-accent sm:h-72"
                         data-game-world3d role="application" aria-label="Mini-game open world 3D kotak" tabindex="0">
                        <canvas data-game-world-canvas class="absolute inset-0 h-full w-full" aria-hidden="true"></canvas>
                        <div aria-hidden="true" class="pointer-events-none absolute inset-0 opacity-20" style="background-image:radial-gradient(#67e8f9 1px,transparent 1px);background-size:24px 24px"></div>
                        <div class="pointer-events-none absolute left-3 top-3 z-10 rounded-lg border border-white/15 bg-black/45 px-3 py-2 backdrop-blur-sm">
                            <span class="block text-[9px] font-semibold uppercase tracking-[.24em] text-cyan-200" data-game-world>NEON CITY</span>
                            <span class="block text-[10px] text-white/70" data-game-world-mechanic>Zona dasar · ritme seimbang</span>
                        </div>
                        <div class="pointer-events-none absolute right-3 top-3 z-10 rounded-lg border border-cyan-200/20 bg-black/55 px-3 py-2 text-right text-[10px] text-white/85 backdrop-blur-sm" data-game-target-hint>KRISTAL · CARI PENANDA</div>
                        <div data-game-player aria-hidden="true" class="absolute bottom-[30px] left-8 grid h-9 w-9 place-items-center rounded-lg border border-white/80 bg-gradient-to-br from-orange-300 via-accent to-rose-700 text-[10px] text-white shadow-[0_0_20px_rgba(232,89,12,0.7)]"><span>✦</span></div>
                        <div aria-hidden="true" class="absolute inset-x-0 bottom-[25px] h-px bg-cyan-300/60 shadow-[0_0_12px_rgba(103,232,249,0.8)]"></div>
                        <p class="pointer-events-none absolute inset-x-4 bottom-3 text-center text-xs text-neutral-300" data-game-status aria-live="polite">Tekan Spasi atau ↑ untuk mulai</p>
                        <div class="absolute bottom-3 left-3 z-10 grid grid-cols-3 gap-1 sm:hidden" data-game-touch-controls aria-label="Kontrol gerak sentuh">
                            <span></span><button type="button" data-world-key="w" class="rounded-lg border border-white/20 bg-black/55 px-3 py-2 text-white">▲</button><span></span>
                            <button type="button" data-world-key="a" class="rounded-lg border border-white/20 bg-black/55 px-3 py-2 text-white">◀</button>
                            <button type="button" data-world-key="s" class="rounded-lg border border-white/20 bg-black/55 px-3 py-2 text-white">▼</button>
                            <button type="button" data-world-key="d" class="rounded-lg border border-white/20 bg-black/55 px-3 py-2 text-white">▶</button>
                        </div>
                        <div class="absolute bottom-3 right-3 z-10 flex gap-2 sm:hidden" data-game-touch-controls>
                            <button type="button" data-world-action="jump" class="rounded-full border border-white/25 bg-black/60 px-3 py-2 text-xs font-bold text-white">LOMPAT</button>
                            <button type="button" data-world-action="dash" class="rounded-full border border-cyan-300/40 bg-cyan-950/70 px-3 py-2 text-xs font-bold text-cyan-100">DASH</button>
                        </div>
                        <div class="pointer-events-none absolute left-1/2 top-1/2 z-10 hidden w-[min(92%,440px)] -translate-x-1/2 -translate-y-1/2" data-game-duel-callout>
                            <div class="rounded-2xl border border-rose-300/40 bg-neutral-950/90 p-5 text-center text-white shadow-[0_0_50px_rgba(244,63,94,.25)] backdrop-blur-md">
                                <p class="text-[10px] font-bold uppercase tracking-[.28em] text-rose-300" data-game-duel-count>DUEL · 1/3</p>
                                <p class="mt-2 text-2xl font-black tracking-wide sm:text-4xl" data-game-duel-instruction>LOMPAT!</p>
                                <p class="mt-1 text-xs text-neutral-300" data-game-duel-hint>Sapuan rendah · Spasi / ↑ / sentuh</p>
                                <div class="mt-4 h-2 overflow-hidden rounded-full bg-white/15">
                                    <div class="h-full w-full origin-left rounded-full bg-gradient-to-r from-amber-300 to-rose-500" data-game-duel-timer></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 z-30 hidden items-center justify-center bg-black/75 p-5 backdrop-blur-sm" data-game-tutorial-overlay>
                            <div class="w-full max-w-sm rounded-2xl border border-cyan-300/30 bg-neutral-950 p-5 text-white shadow-2xl">
                                <p class="text-xs font-semibold uppercase tracking-[.2em] text-cyan-300" data-game-tutorial-step>PELATIHAN · 1/4</p>
                                <h3 class="mt-2 text-xl font-semibold" data-game-tutorial-title>Lompatan</h3>
                                <p class="mt-2 text-sm leading-relaxed text-neutral-300" data-game-tutorial-copy>Tekan Spasi, ↑, atau sentuh arena. Tahan sebentar untuk melompat lebih tinggi.</p>
                                <div class="mt-5 flex gap-3">
                                    <button type="button" data-game-tutorial-next class="rounded-full bg-accent px-4 py-2 text-sm font-semibold">Lanjut</button>
                                    <button type="button" data-game-tutorial-skip class="rounded-full border border-white/20 px-4 py-2 text-sm">Lewati</button>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 z-20 hidden items-center justify-center bg-black/70 p-5 backdrop-blur-sm" data-game-pause-overlay>
                            <div class="rounded-2xl border border-white/20 bg-neutral-950/95 p-6 text-center text-white">
                                <h3 class="text-2xl font-semibold">Permainan dijeda</h3>
                                <p class="mt-2 text-sm text-neutral-300">Tekan P atau lanjutkan saat siap.</p>
                                <button type="button" data-game-resume class="mt-4 rounded-full bg-accent px-5 py-2 text-sm font-semibold">Lanjutkan</button>
                            </div>
                        </div>
                        <div class="absolute inset-0 z-20 hidden items-center justify-center bg-black/80 p-5 backdrop-blur-sm" data-game-summary-overlay>
                            <div class="w-full max-w-md rounded-2xl border border-white/15 bg-neutral-950/95 p-5 text-white shadow-2xl">
                                <p class="text-xs font-semibold uppercase tracking-[.2em] text-orange-300">RUN SELESAI</p>
                                <h3 class="mt-1 text-2xl font-semibold">Rekap permainan</h3>
                                <div class="mt-4 grid grid-cols-2 gap-2 text-sm" data-game-summary-stats></div>
                                <p class="mt-4 text-xs font-semibold uppercase tracking-wider text-cyan-200">Pencapaian</p>
                                <div class="mt-2 flex flex-wrap gap-2 text-xs" data-game-achievements></div>
                                <p class="mt-3 text-xs text-neutral-400" data-game-progress></p>
                                <button type="button" data-game-restart class="mt-5 rounded-full bg-accent px-5 py-2.5 text-sm font-semibold">Main lagi</button>
                            </div>
                        </div>
                    </div>

                    <div data-game-actions class="mt-4 flex flex-wrap items-center gap-4">
                        <button type="button" data-game-action class="rounded-full bg-accent px-5 py-3 text-sm font-medium text-white transition hover:brightness-110 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent">
                            Mulai / Lompat
                        </button>
                        <button type="button" data-game-dash-action class="rounded-full border border-cyan-500/60 px-4 py-3 text-sm font-medium text-cyan-600 transition hover:bg-cyan-500/10 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-cyan-500 dark:text-cyan-300" aria-label="Gunakan dash">
                            Dash (Shift)
                        </button>
                        <button type="button" data-game-overdrive-action class="rounded-full border border-fuchsia-500/60 px-4 py-3 text-sm font-medium text-fuchsia-700 transition hover:bg-fuchsia-500/10 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-fuchsia-500 dark:text-fuchsia-300" aria-label="Aktifkan Overdrive" disabled>
                            Overdrive (X)
                        </button>
                        <button type="button" data-game-music aria-pressed="true" class="rounded-full border border-neutral-300 px-4 py-3 text-sm transition hover:border-accent focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent dark:border-neutral-700">
                            Musik: Nyala
                        </button>
                        <span class="text-xs text-neutral-500" data-game-power aria-live="polite">Perisai: 0</span>
                        <p class="text-xs text-neutral-500">WASD / panah = bergerak · tarik arena = putar kamera · Spasi = lompat · Shift = Dash · E = ambil portal / kalahkan penjaga.</p>
                    </div>
                </div>
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
