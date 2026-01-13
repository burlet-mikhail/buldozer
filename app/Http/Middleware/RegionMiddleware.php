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

        // Главный домен — используем регион из сессии/cookie или default
        if (in_array($subdomain, config('regions.main_subdomains', ['buldozer', 'www']))) {
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
     * Извлечь поддомен из хоста.
     */
    private function getSubdomain(Request $request): string {
        $parts = explode('.', $request->getHost());

        return $parts[0];
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
