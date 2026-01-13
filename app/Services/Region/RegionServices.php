<?php

namespace App\Services\Region;

use App\Models\Region;

class RegionServices {

    /**
     * Установить текущий регион.
     */
    public function set(int $id): void {
        session()->put('region', $id);
        cookie()->queue('region', $id, config('regions.cookie_lifetime'));
    }

    /**
     * Получить ID текущего региона.
     * Приоритет: сессия → cookie → default
     */
    public function getId(): int {
        $regionId = session('region') ?? request()->cookie('region');

        if ($regionId && $this->regionExists((int) $regionId)) {
            return (int) $regionId;
        }

        return $this->getDefaultId();
    }

    /**
     * Получить ID региона по умолчанию.
     */
    public function getDefaultId(): int {
        return cache()->rememberForever('default_region_id', function () {
            return Region::query()
                ->where('default', true)
                ->value('id') ?? config('regions.default_region_id');
        });
    }

    /**
     * Проверить существование региона.
     */
    public function regionExists(int $id): bool {
        return cache()->rememberForever("region_exists.{$id}", function () use ($id) {
            return Region::query()->where('id', $id)->exists();
        });
    }

    /**
     * Получить название текущего региона.
     */
    public function getName(): string {
        return $this->getRegionAttribute('name') ?? '';
    }

    /**
     * Получить slug текущего региона.
     */
    public function getSlug(): string {
        return $this->getRegionAttribute('slug') ?? 'moscow';
    }

    /**
     * Получить атрибут региона с кешированием.
     */
    private function getRegionAttribute(string $attribute): ?string {
        $id = $this->getId();

        return cache()->rememberForever("region.{$id}.{$attribute}", function () use ($id, $attribute) {
            return Region::query()->where('id', $id)->value($attribute);
        });
    }

}
