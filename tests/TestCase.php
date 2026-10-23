<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    // Semua test memakai database bersih (SQLite di memori).
    // Ditaruh di sini supaya pengaman di bawah benar-benar dipakai.
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Test fokus ke PHP & HTML, tidak bergantung pada npm run dev / build
        $this->withoutVite();
    }

    /**
     * Pengaman: dijalankan oleh RefreshDatabase SEBELUM database dihapus & dibuat ulang.
     * Kalau test tidak terhubung ke SQLite di memori (misalnya karena config di-cache),
     * hentikan semuanya supaya database asli tidak terhapus.
     */
    protected function beforeRefreshingDatabase()
    {
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");

        if ($connection !== 'sqlite' || $database !== ':memory:') {
            throw new RuntimeException(
                "Refusing to reset the [{$connection}] database during tests. " .
                'Run "php artisan optimize:clear" and try again.'
            );
        }
    }
}