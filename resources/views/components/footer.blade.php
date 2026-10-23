<footer class="border-t border-neutral-200 dark:border-neutral-800">
    <div class="mx-auto flex max-w-5xl flex-col gap-4 px-6 py-10 text-sm text-neutral-500 sm:flex-row sm:items-center sm:justify-between">
        <p>
            &copy; {{ now()->year }} {{ config('portfolio.name') }}. Built with Laravel &amp; Tailwind CSS.
        </p>
        <a href="#hero" class="transition-colors hover:text-accent">Back to top ↑</a>
    </div>
</footer>