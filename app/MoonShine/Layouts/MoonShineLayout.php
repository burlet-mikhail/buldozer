<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\CallbackResource;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\CityResource;
use App\MoonShine\Resources\OptionResource;
use App\MoonShine\Resources\PageResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\RegionResource;
use App\MoonShine\Resources\SeoResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\Layout\Layout;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make('Объекты', [
                MenuItem::make('Все объекты', ProductResource::class),
                MenuItem::make('Категории', CategoryResource::class),
                MenuItem::make('Регионы', RegionResource::class),
                MenuItem::make('Города', CityResource::class),
                MenuItem::make('Опции', OptionResource::class),
            ]),
            MenuItem::make('Страницы', PageResource::class),
            MenuItem::make('SEO', SeoResource::class),
            MenuItem::make('Заявки', CallbackResource::class),
            MenuItem::make('Пользователи', UserResource::class),
        ];
    }

    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
