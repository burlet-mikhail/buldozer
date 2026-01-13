<?php

namespace App\Http\Middleware;

use App\Models\Region;
use App\Services\Region\RegionServices;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegionMiddleware {

    public function __construct(
        private RegionServices $regionService
    ) {}

    public function handle(Request $request, Closure $next): Response {
        // Пропускаем для страниц объектов (уже определён регион в URL)
        if (str($request->url())->contains('/object/')) {
            return $next($request);
        }

        $subdomain = $this->getSubdomain($request);

        // Основной домен (без поддомена) или www — используем регион из сессии/cookie
        if ($subdomain === null || $subdomain === 'www') {
            $this->ensureRegionSet();
            return $next($request);
        }

        // Поддомен региона
        $region = $this->getRegionBySlug($subdomain);

        if (!$region) {
            return redirect(config('app.url'));
        }

        // Устанавливаем регион только если он изменился
        if ((int) session('region') !== $region->id) {
            $this->regionService->set($region->id);
        }

        return $next($request);
    }

    /**
     * Извлечь поддомен из хоста относительно базового домена.
     *
     * bldzr.ru → null (основной домен)
     * www.bldzr.ru → www
     * moscow.bldzr.ru → moscow
     */
    private function getSubdomain(Request $request): ?string {
        $host = $request->getHost();
        $baseDomain = $this->getBaseDomain();

        // Если хост совпадает с базовым доменом — это основной сайт
        if ($host === $baseDomain) {
            return null;
        }

        // Извлекаем поддомен: moscow.bldzr.ru → moscow
        if (str_ends_with($host, '.' . $baseDomain)) {
            return substr($host, 0, -strlen('.' . $baseDomain));
        }

        // Fallback для dev окружения с другими доменами
        $parts = explode('.', $host);
        return $parts[0];
    }

    /**
     * Получить базовый домен из APP_URL.
     */
    private function getBaseDomain(): string {
        $appUrl = config('app.url');
        $parsed = parse_url($appUrl);

        return $parsed['host'] ?? 'localhost';
    }

    /**
     * Получить регион по slug с кешированием.
     */
    private function getRegionBySlug(string $slug): ?Region {
        return cache()->rememberForever(
            "region.{$slug}",
            fn () => Region::query()->where('slug', $slug)->first()
        );
    }

    /**
     * Убедиться что регион установлен (для главного домена).
     */
    private function ensureRegionSet(): void {
        if (!session('region') && !request()->cookie('region')) {
            $this->regionService->set($this->regionService->getDefaultId());
        }
    }

}
