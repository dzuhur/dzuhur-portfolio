<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Admin') · {{ config('portfolio.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|instrument-serif:400,400i" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-50 font-sans text-neutral-900 antialiased dark:bg-neutral-950 dark:text-neutral-100">
    @auth
        <x-admin.nav />
    @endauth

    @if (session('status'))
        <div class="mx-auto max-w-5xl px-6 pt-6">
            <p role="status" class="rounded-lg border border-accent/30 bg-accent/5 px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">
                {{ session('status') }}
            </p>
        </div>
    @endif

    @yield('content')
</body>
</html>