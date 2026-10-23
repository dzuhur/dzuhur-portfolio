<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Visitor;
use Carbon\CarbonImmutable;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now(config('portfolio.timezone'))->toImmutable();

        $periods = [
            'Today' => $now->startOfDay(),
            'This week' => $now->startOfWeek(CarbonImmutable::MONDAY),
            'This month' => $now->startOfMonth(),
            'All time' => null,
        ];

        $visitorStats = collect($periods)->map(fn ($start) => $this->visitorStats($start));

        $topReferrers = Visitor::query()
            ->whereNotNull('referer')
            ->where('visited_at', '>=', $now->startOfMonth()->utc())
            ->selectRaw('referer, COUNT(*) as total')
            ->groupBy('referer')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'visitorStats' => $visitorStats,
            'resumeDownloads' => Visitor::where('page', '/resume')->count(),
            'projectCount' => Project::count(),
            'messageCount' => ContactMessage::count(),
            'unreadCount' => ContactMessage::whereNull('read_at')->count(),
            'topReferrers' => $topReferrers,
        ]);
    }

    /**
     * Hitung unique visitors dan page views halaman utama sejak $start (WIB).
     * $start = null artinya sepanjang waktu.
     */
    private function visitorStats(?CarbonImmutable $start): array
    {
        $query = Visitor::query()->where('page', '/');

        if ($start) {
            $query->where('visited_at', '>=', $start->utc());
        }

        return [
            'unique' => (clone $query)->distinct()->count('ip_hash'),
            'views' => (clone $query)->count(),
        ];
    }
}