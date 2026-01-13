<?php

namespace App\Services\Sitemap\Generators;

class MainPageGenerator extends AbstractGenerator
{
    public function generate(): array
    {
        $sitemap = $this->createSitemap();

        $sitemap->add(
            $this->createUrl(
                $this->domain,
                now(),
                config('sitemap.changefreq.home'),
                config('sitemap.priorities.home')
            )
        );

        $sitemap->add(
            $this->createUrl(
                $this->buildUrl('/catalog'),
                now(),
                config('sitemap.changefreq.catalog'),
                config('sitemap.priorities.catalog')
            )
        );

        $filename = 'sitemap-main.xml';
        $this->writeSitemap($sitemap, $filename);

        return [$filename];
    }
}
