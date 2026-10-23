@props(['number', 'title', 'sticky' => true])

<div @class([
    'md:sticky md:top-28 md:self-start' => $sticky,
])>
    <p class="text-sm font-medium tracking-[0.2em] text-accent">{{ $number }}</p>
    <h2 class="mt-3 font-serif text-4xl sm:text-5xl">{{ $title }}</h2>
</div>