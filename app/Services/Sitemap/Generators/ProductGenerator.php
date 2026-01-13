<?php

namespace App\Services\Sitemap\Generators;

use App\Models\Product;
use Spatie\Sitemap\Tags\Url;

class ProductGenerator extends AbstractGenerator
{
    public function generate(): array
    {
        $files = [];
        $chunkSize = config('sitemap.chunk_size');
        $chunkIndex = 0;

        $totalCount = Product::query()->where('active', true)->count();

        if ($totalCount === 0) {
            $filename = 'sitemap-products-0.xml';
            $this->writeSitemap($this->createSitemap(), $filename);
            return [$filename];
        }

        Product::query()
            ->where('active', true)
            ->select(['id', 'slug', 'title', 'thumbnail', 'updated_at'])
            ->orderBy('id')
            ->chunk($chunkSize, function ($products) use (&$files, &$chunkIndex) {
                $sitemap = $this->createSitemap();

                foreach ($products as $product) {
                    $url = Url::create($this->buildUrl("/object/{$product->slug}"))
                        ->setLastModificationDate($product->updated_at)
                        ->setChangeFrequency(config('sitemap.changefreq.product'))
                        ->setPriority(config('sitemap.priorities.product'));

                    // Добавляем изображение если есть
                    $this->addProductImage($url, $product);

                    $sitemap->add($url);
                }

                $filename = "sitemap-products-{$chunkIndex}.xml";
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

        // Генерируем URL изображения через маршрут thumbnail
        $imageUrl = $product->makeThumbnail($firstImage, '800x600', (string) $product->id, 'fit');

        $url->addImage($imageUrl, $product->title);
    }
}
