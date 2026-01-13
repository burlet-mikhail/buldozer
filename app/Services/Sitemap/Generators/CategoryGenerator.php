<?php

namespace App\Services\Sitemap\Generators;

use App\Models\Category;

class CategoryGenerator extends AbstractGenerator
{
    public function generate(): array
    {
        $files = [];
        $chunkSize = config('sitemap.chunk_size');
        $chunkIndex = 0;

        // Только категории с активными товарами
        $totalCount = Category::query()
            ->where('active', true)
            ->whereHas('products', fn($q) => $q->where('active', true))
            ->count();

        if ($totalCount === 0) {
            $filename = 'sitemap-categories-0.xml';
            $this->writeSitemap($this->createSitemap(), $filename);
            return [$filename];
        }

        Category::query()
            ->where('active', true)
            ->whereHas('products', fn($q) => $q->where('active', true))
            ->select(['slug', 'updated_at'])
            ->orderBy('id')
            ->chunk($chunkSize, function ($categories) use (&$files, &$chunkIndex) {
                $sitemap = $this->createSitemap();

                foreach ($categories as $category) {
                    $sitemap->add(
                        $this->createUrl(
                            $this->buildUrl("/catalog/category/{$category->slug}"),
                            $category->updated_at,
                            config('sitemap.changefreq.category'),
                            config('sitemap.priorities.category')
                        )
                    );
                }

                $filename = "sitemap-categories-{$chunkIndex}.xml";
                $this->writeSitemap($sitemap, $filename);
                $files[] = $filename;
                $chunkIndex++;

                unset($sitemap);
                gc_collect_cycles();
            });

        return $files;
    }
}
