<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Contact form: 5 kiriman per 10 menit per IP
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinutes(10, 5)
                ->by($request->ip())
                ->response(function () {
                    return redirect()->to(route('home') . '#send-message')
                        ->withInput()
                        ->withErrors(['message' => 'Too many messages sent. Please wait a few minutes and try again.']);
                });
        });

        // Admin login: 5 percobaan per menit per kombinasi email + IP
        RateLimiter::for('login', function (Request $request) {
            $key = Str::lower((string) $request->input('email')) . '|' . $request->ip();

            return Limit::perMinute(5)
                ->by($key)
                ->response(function (Request $request) {
                    return back()
                        ->withInput($request->only('email'))
                        ->withErrors(['email' => 'Too many login attempts. Please try again in a minute.']);
                });
        });
    }
}