<?php

namespace App\Services\Sitemap;

use App\Models\Region;
use App\Services\Sitemap\Generators\AbstractGenerator;
use App\Services\Sitemap\Generators\CategoryGenerator;
use App\Services\Sitemap\Generators\CityGenerator;
use App\Services\Sitemap\Generators\MainPageGenerator;
use App\Services\Sitemap\Generators\PageGenerator;
use App\Services\Sitemap\Generators\ProductGenerator;
use App\Services\Sitemap\Generators\RegionGenerator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Spatie\Sitemap\SitemapIndex;

class SitemapService
{
    private string $basePath;
    private string $domain;

    public function __construct()
    {
        $this->basePath = config('sitemap.path');
        $this->domain = rtrim(config('sitemap.domain'), '/');
    }

    /**
     * Генерирует все sitemap файлы
     */
    public function generateAll(): array
    {
        $this->ensureDirectoriesExist();

        // Очищаем старые файлы
        $this->cleanOldFiles();

        $allFiles = [];

        // Базовые генераторы
        $generators = [
            new MainPageGenerator(),
            new ProductGenerator(),
            new CategoryGenerator(),
            new CityGenerator(),
            new PageGenerator(),
        ];

        foreach ($generators as $generator) {
            $files = $generator->generate();
            $allFiles = array_merge($allFiles, $files);

            // Освобождаем память после каждого генератора
            unset($generator);
            gc_collect_cycles();
        }

        // Генераторы регионов (по одному за раз для экономии памяти)
        Region::query()
            ->where('active', true)
            ->select(['id', 'slug'])
            ->orderBy('id')
            ->chunk(10, function ($regions) use (&$allFiles) {
                foreach ($regions as $region) {
                    $generator = new RegionGenerator($region);
                    $files = $generator->generate();
                    $allFiles = array_merge($allFiles, $files);

                    unset($generator);
                }
                gc_collect_cycles();
            });

        // Создаём sitemap index
        $this->createSitemapIndex($allFiles);

        // Сбрасываем кеш
        $this->clearCache();

        return [
            'files' => count($allFiles),
            'filenames' => $allFiles,
        ];
    }

    /**
     * Создаёт sitemap index
     */
    private function createSitemapIndex(array $files): void
    {
        $sitemapIndex = SitemapIndex::create();

        foreach ($files as $filename) {
            $sitemapIndex->add("{$this->domain}/sitemaps/{$filename}");
        }

        $sitemapIndex->writeToFile(public_path('sitemap.xml'));
    }

    /**
     * Создает необходимые директории
     */
    private function ensureDirectoriesExist(): void
    {
        if (!File::isDirectory($this->basePath)) {
            File::makeDirectory($this->basePath, 0755, true);
        }
    }

    /**
     * Очищает старые sitemap файлы
     */
    private function cleanOldFiles(): void
    {
        if (File::isDirectory($this->basePath)) {
            $files = File::glob($this->basePath . '/*.xml');
            foreach ($files as $file) {
                File::delete($file);
            }
        }

        $indexFile = public_path('sitemap.xml');
        if (File::exists($indexFile)) {
            File::delete($indexFile);
        }
    }

    /**
     * Получить содержимое sitemap из кеша или файла
     */
    public function getCached(string $filename): ?string
    {
        $cacheKey = config('sitemap.cache_key') . '.' . md5($filename);
        $cacheTtl = config('sitemap.cache_ttl');

        return Cache::remember($cacheKey, $cacheTtl * 60, function () use ($filename) {
            $filepath = $this->basePath . '/' . $filename;

            if (File::exists($filepath)) {
                return File::get($filepath);
            }

            return null;
        });
    }

    /**
     * Получить главный sitemap.xml
     */
    public function getIndex(): ?string
    {
        $cacheKey = config('sitemap.cache_key') . '.index';
        $cacheTtl = config('sitemap.cache_ttl');

        return Cache::remember($cacheKey, $cacheTtl * 60, function () {
            $filepath = public_path('sitemap.xml');

            if (File::exists($filepath)) {
                return File::get($filepath);
            }

            return null;
        });
    }

    /**
     * Сброс кеша sitemap
     */
    public function clearCache(): void
    {
        Cache::forget(config('sitemap.cache_key') . '.index');

        if (File::isDirectory($this->basePath)) {
            $files = File::allFiles($this->basePath);
            foreach ($files as $file) {
                $key = config('sitemap.cache_key') . '.' . md5($file->getRelativePathname());
                Cache::forget($key);
            }
        }
    }
}
