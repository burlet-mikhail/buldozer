<?php

namespace App\Console\Commands;

use App\Services\Sitemap\SitemapService;
use Illuminate\Console\Command;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate
                            {--clear-cache : Только очистить кеш без генерации}';

    protected $description = 'Генерация SEO sitemap для всех страниц включая поддомены';

    public function handle(SitemapService $sitemapService): int
    {
        if ($this->option('clear-cache')) {
            $this->info('Очистка кеша sitemap...');
            $sitemapService->clearCache();
            $this->info('Кеш очищен.');

            return self::SUCCESS;
        }

        $this->info('Начало генерации sitemap...');

        $startTime = microtime(true);

        try {
            $stats = $sitemapService->generateAll();

            $duration = round(microtime(true) - $startTime, 2);

            $this->info("Sitemap успешно сгенерирован за {$duration} сек.");
            $this->info("Создано файлов: {$stats['files']}");
            $this->newLine();
            $this->line('Файлы:');
            $this->line('  - public/sitemap.xml (index)');
            $this->line('  - public/sitemaps/*.xml');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("Ошибка генерации: {$e->getMessage()}");
            $this->error($e->getTraceAsString());

            return self::FAILURE;
        }
    }
}
