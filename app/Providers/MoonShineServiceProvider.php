<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\CallbackResource;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\CityResource;
use App\MoonShine\Resources\OptionResource;
use App\MoonShine\Resources\OptionValuesResource;
use App\MoonShine\Resources\PageResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\RegionResource;
use App\MoonShine\Resources\SeoResource;
use App\MoonShine\Resources\UserResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        $core
            ->resources([
                ProductResource::class,
                CategoryResource::class,
                UserResource::class,
                PageResource::class,
                SeoResource::class,
                RegionResource::class,
                CityResource::class,
                OptionResource::class,
                OptionValuesResource::class,
                CallbackResource::class,
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
            ])
            ->pages([
                ...$config->getPages(),
            ]);
    }
}
