<?php

namespace App\Services\Sitemap\Generators;

use App\Models\Page;

class PageGenerator extends AbstractGenerator
{
    public function generate(): array
    {
        $sitemap = $this->createSitemap();

        Page::query()
            ->select(['slug', 'updated_at'])
            ->orderBy('id')
            ->each(function (Page $page) use ($sitemap) {
                $sitemap->add(
                    $this->createUrl(
                        $this->buildUrl("/{$page->slug}"),
                        $page->updated_at,
                        config('sitemap.changefreq.page'),
                        config('sitemap.priorities.page')
                    )
                );
            });

        $filename = 'sitemap-pages.xml';
        $this->writeSitemap($sitemap, $filename);

        return [$filename];
    }
}
