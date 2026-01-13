<?php

namespace App\Services\Sitemap\Generators;

use App\Models\City;

class CityGenerator extends AbstractGenerator
{
    public function generate(): array
    {
        $files = [];
        $chunkSize = config('sitemap.chunk_size');
        $chunkIndex = 0;

        // Только города с активными товарами
        $totalCount = City::query()
            ->where('active', true)
            ->whereHas('products', fn($q) => $q->where('active', true))
            ->count();

        if ($totalCount === 0) {
            $filename = 'sitemap-cities-0.xml';
            $this->writeSitemap($this->createSitemap(), $filename);
            return [$filename];
        }

        City::query()
            ->where('active', true)
            ->whereHas('products', fn($q) => $q->where('active', true))
            ->select(['slug', 'updated_at'])
            ->orderBy('id')
            ->chunk($chunkSize, function ($cities) use (&$files, &$chunkIndex) {
                $sitemap = $this->createSitemap();

                foreach ($cities as $city) {
                    $sitemap->add(
                        $this->createUrl(
                            $this->buildUrl("/catalog/city/{$city->slug}"),
                            $city->updated_at,
                            config('sitemap.changefreq.city'),
                            config('sitemap.priorities.city')
                        )
                    );
                }

                $filename = "sitemap-cities-{$chunkIndex}.xml";
                $this->writeSitemap($sitemap, $filename);
                $files[] = $filename;
                $chunkIndex++;

                unset($sitemap);
                gc_collect_cycles();
            });

        return $files;
    }
}
