<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\CharacteristicFilter;
use App\Filters\FilterManager;
use App\Filters\PriceFilter;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\Region;
use App\Observers\CategoryObserver;
use App\Observers\ProductObserver;
use App\Observers\RegionObserver;
use App\Services\Region\RegionServices;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Support\Telegram;

class AppServiceProvider extends ServiceProvider {

    public function register(): void {
        $this->app->singleton(Telegram::class, function ($app) {
            return new Telegram(new Http(), config('bot.bot'));
        });
        $this->app->singleton(FilterManager::class);
        $this->app->singleton(RegionServices::class);
    }

    public function boot(): void {

        Region::observe( RegionObserver::class );
        Product::observe( ProductObserver::class );
        Category::observe( CategoryObserver::class );


        Route::model( 'category:slug', Category::class );
        Route::model( 'city:slug', City::class );

    }
}
