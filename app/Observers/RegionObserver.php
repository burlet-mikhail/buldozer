<?php

namespace App\Observers;

use App\Models\Region;

class RegionObserver {

    public function created(Region $region): void {
        $this->clearCache($region);
    }

    public function updated(Region $region): void {
        $this->clearCache($region);
    }

    public function deleted(Region $region): void {
        $this->clearCache($region);
    }

    /**
     * Очистить кеш связанный с регионом.
     */
    private function clearCache(Region $region): void {
        // Кеш по slug
        cache()->forget("region.{$region->slug}");

        // Кеш существования региона
        cache()->forget("region_exists.{$region->id}");

        // Кеш атрибутов региона
        cache()->forget("region.{$region->id}.name");
        cache()->forget("region.{$region->id}.slug");

        // Общий кеш регионов
        cache()->forget('regions.modal');
        cache()->forget('add_regions');

        // Если это регион по умолчанию — сбросить кеш default
        if ($region->default) {
            cache()->forget('default_region_id');
        }

        // Если slug изменился — очистить старый кеш
        if ($region->wasChanged('slug')) {
            cache()->forget("region.{$region->getOriginal('slug')}");
        }
    }

}
