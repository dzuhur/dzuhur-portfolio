<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Kata kunci user agent yang menandakan bot/crawler.
     */
        private const BOT_KEYWORDS = [
        'bot', 'crawl', 'spider', 'slurp', 'preview', 'headless', 'facebookexternalhit',
        'curl', 'wget', 'python-requests',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Tidak melakukan apa-apa sebelum controller. Pencatatan ada di terminate().
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (! $this->shouldTrack($request, $response)) {
            return;
        }

        Visitor::create([
            'ip_hash' => $this->hashIp($request->ip()),
            'user_agent' => Str::limit((string) $request->userAgent(), 255, ''),
            'page' => '/' . ltrim($request->path(), '/'),
            'referer' => $this->refererHost($request),
            'visited_at' => now(),
        ]);
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        // Hanya kunjungan halaman biasa (bukan submit form)
        if (! $request->isMethod('GET')) {
            return false;
        }

        // Hanya response sukses (bukan redirect atau halaman error)
        if (! $response->isSuccessful()) {
            return false;
        }

        // Hormati Global Privacy Control
        if ($request->header('Sec-GPC') === '1') {
            return false;
        }

        // Abaikan prefetch dari browser
        if ($request->header('Sec-Purpose') === 'prefetch' || $request->header('Purpose') === 'prefetch') {
            return false;
        }

        // Abaikan bot dan request tanpa user agent
        $userAgent = (string) $request->userAgent();

        if ($userAgent === '' || Str::contains($userAgent, self::BOT_KEYWORDS, ignoreCase: true)) {
            return false;
        }

        // Abaikan admin yang sedang login (aktif setelah Phase 7)
        if ($request->user()) {
            return false;
        }

        return true;
    }

        private function hashIp(?string $ip): string
    {
        $data = ($ip ?? 'unknown') . '|' . now()->toDateString();

        return hash_hmac('sha256', $data, config('app.key'));
    }

    private function refererHost(Request $request): ?string
    {
        $referer = $request->headers->get('referer');

        if (! $referer) {
            return null;
        }

        $host = parse_url($referer, PHP_URL_HOST);

        // Abaikan referer yang tidak valid atau berasal dari website sendiri
        if (! $host || $host === $request->getHost()) {
            return null;
        }

        return Str::limit(Str::lower($host), 255, '');
    }
}