<?php

namespace App\Services\Sitemap\Generators;

use App\Models\Product;
use App\Models\Region;
use Spatie\Sitemap\Tags\Url;

class RegionGenerator extends AbstractGenerator
{
    public function __construct(
        private readonly Region $region
    ) {
        parent::__construct();
    }

    public function generate(): array
    {
        $productCount = Product::query()
            ->where('active', true)
            ->where('region_id', $this->region->id)
            ->count();

        // Если нет товаров в регионе — не генерируем sitemap
        if ($productCount === 0) {
            return [];
        }

        $files = [];
        $chunkSize = config('sitemap.chunk_size');
        $chunkIndex = 0;

        // Если мало товаров, делаем один файл
        if ($productCount < $chunkSize) {
            $sitemap = $this->createSitemap();

            // Главная поддомена
            $sitemap->add(
                $this->createUrl(
                    $this->buildSubdomainUrl($this->region->slug, '/catalog'),
                    now(),
                    config('sitemap.changefreq.region_catalog'),
                    config('sitemap.priorities.region_catalog')
                )
            );

            // Товары региона
            Product::query()
                ->where('active', true)
                ->where('region_id', $this->region->id)
                ->select(['id', 'slug', 'title', 'thumbnail', 'updated_at'])
                ->orderBy('id')
                ->each(function ($product) use ($sitemap) {
                    $url = Url::create($this->buildSubdomainUrl($this->region->slug, "/object/{$product->slug}"))
                        ->setLastModificationDate($product->updated_at)
                        ->setChangeFrequency(config('sitemap.changefreq.region_product'))
                        ->setPriority(config('sitemap.priorities.region_product'));

                    $this->addProductImage($url, $product);

                    $sitemap->add($url);
                });

            $filename = "sitemap-region-{$this->region->slug}.xml";
            $this->writeSitemap($sitemap, $filename);

            return [$filename];
        }

        // Много товаров — разбиваем на чанки
        $isFirst = true;

        Product::query()
            ->where('active', true)
            ->where('region_id', $this->region->id)
            ->select(['id', 'slug', 'title', 'thumbnail', 'updated_at'])
            ->orderBy('id')
            ->chunk($chunkSize - ($isFirst ? 1 : 0), function ($products) use (&$files, &$chunkIndex, &$isFirst) {
                $sitemap = $this->createSitemap();

                // Добавляем главную страницу в первый файл
                if ($isFirst) {
                    $sitemap->add(
                        $this->createUrl(
                            $this->buildSubdomainUrl($this->region->slug, '/catalog'),
                            now(),
                            config('sitemap.changefreq.region_catalog'),
                            config('sitemap.priorities.region_catalog')
                        )
                    );
                    $isFirst = false;
                }

                foreach ($products as $product) {
                    $url = Url::create($this->buildSubdomainUrl($this->region->slug, "/object/{$product->slug}"))
                        ->setLastModificationDate($product->updated_at)
                        ->setChangeFrequency(config('sitemap.changefreq.region_product'))
                        ->setPriority(config('sitemap.priorities.region_product'));

                    $this->addProductImage($url, $product);

                    $sitemap->add($url);
                }

                $filename = $chunkIndex === 0
                    ? "sitemap-region-{$this->region->slug}.xml"
                    : "sitemap-region-{$this->region->slug}-{$chunkIndex}.xml";

                $this->writeSitemap($sitemap, $filename);
                $files[] = $filename;
                $chunkIndex++;

                unset($sitemap);
                gc_collect_cycles();
            });

        return $files;
    }

    private function addProductImage(Url $url, Product $product): void
    {
        if (empty($product->thumbnail) || !is_array($product->thumbnail)) {
            return;
        }

        $firstImage = $product->thumbnail[0] ?? null;

        if (!$firstImage) {
            return;
        }

        $imageUrl = $product->makeThumbnail($firstImage, '800x600', (string) $product->id, 'fit');

        $url->addImage($imageUrl, $product->title);
    }
}
