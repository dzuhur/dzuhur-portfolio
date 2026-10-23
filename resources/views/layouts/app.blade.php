<!DOCTYPE html>
<html lang="en" class="motion-safe:scroll-smooth scroll-pt-20">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('portfolio.seo.title'))</title>
    <meta name="description" content="@yield('description', config('portfolio.seo.description'))">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    {{-- Open Graph: tampilan saat link dibagikan --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('portfolio.name') }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:title" content="@yield('title', config('portfolio.seo.title'))">
    <meta property="og:description" content="@yield('description', config('portfolio.seo.description'))">
    <meta property="og:url" content="{{ url()->current() }}">

    @if (config('portfolio.seo.og_image'))
        <meta property="og:image" content="{{ asset(config('portfolio.seo.og_image')) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ config('portfolio.name') }} — portfolio">
        <meta name="twitter:card" content="summary_large_image">
    @else
        <meta name="twitter:card" content="summary">
    @endif

    {{-- Warna address bar browser di HP --}}
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0a0a0a" media="(prefers-color-scheme: dark)">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|instrument-serif:400,400i" rel="stylesheet">
    @stack('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head></head>
<body class="bg-white font-sans text-neutral-900 antialiased dark:bg-neutral-950 dark:text-neutral-100">
    <a href="#main"
       class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-md focus:bg-accent focus:px-4 focus:py-2 focus:text-white">
        Skip to content
    </a>

    <x-navbar />

    @yield('content')

    <x-footer />
</body>
</html>