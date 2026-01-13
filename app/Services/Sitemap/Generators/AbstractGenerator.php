<?php

namespace App\Services\Sitemap\Generators;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

abstract class AbstractGenerator
{
    protected string $domain;
    protected string $basePath;

    public function __construct()
    {
        $this->domain = rtrim(config('sitemap.domain'), '/');
        $this->basePath = config('sitemap.path');
    }

    /**
     * Генерирует sitemap файлы и записывает их на диск
     * Возвращает массив имён созданных файлов
     *
     * @return string[]
     */
    abstract public function generate(): array;

    protected function buildUrl(string $path): string
    {
        return $this->domain . '/' . ltrim($path, '/');
    }

    protected function buildSubdomainUrl(string $subdomain, string $path = ''): string
    {
        $parsed = parse_url($this->domain);
        $scheme = $parsed['scheme'] ?? 'https';
        $host = $parsed['host'] ?? 'buldozer.ru';

        $url = "{$scheme}://{$subdomain}.{$host}";

        if ($path) {
            $url .= '/' . ltrim($path, '/');
        }

        return $url;
    }

    protected function createSitemap(): Sitemap
    {
        return Sitemap::create();
    }

    protected function writeSitemap(Sitemap $sitemap, string $filename): void
    {
        $sitemap->writeToFile($this->basePath . '/' . $filename);
    }

    protected function createUrl(string $loc, ?\Carbon\Carbon $lastmod = null, string $changefreq = 'weekly', float $priority = 0.5): Url
    {
        return Url::create($loc)
            ->setLastModificationDate($lastmod ?? now())
            ->setChangeFrequency($changefreq)
            ->setPriority($priority);
    }
}
