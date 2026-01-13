<?php

namespace App\Http\Controllers;

use App\Filters\CharacteristicFilter;
use App\Filters\FilterManager;
use App\Models\Category;
use App\Models\City;
use App\Models\Option;
use App\Models\Product;
use App\Services\Region\RegionServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class CatalogController extends Controller {


    public function __invoke(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        Option::query()->update([
            'template' => 'select',
            'filter' => true,
        ]);
        return $this->processCatalog();
    }

    public function showCategory( $category, City|null $city = null ): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $category = Category::query()->where( 'slug', $category )->first();

        return $this->processCatalog( $category, $city );
    }

    public function showCity($city, Category|null $category = null): Application|Factory|View|\Illuminate\Contracts\Foundation\Application {
        $city = City::query()->with('region')->where('slug', $city)->first();

        // Устанавливаем регион города если он отличается от текущего
        if ($city->region_id !== region()) {
            app(RegionServices::class)->set($city->region_id);
        }

        return $this->processCatalog($category, $city);
    }

    protected function processCatalog( Category $category = null, City|null $city = null ): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {

        $key = hash( 'md5', implode( '_', [
            $category->slug ?? null,
            $city->slug ?? null,
            region(),
        ] ) );


        $products = Product::query()
                           ->select( [ 'id', 'title', 'contact' ] )
                           ->active()
                            ->filtered()
                           ->withCategory( $category )
                           ->withCity( $city )
                           ->withRegion();

        $ids = $products->get( 'id' );

        app( FilterManager::class )->registerFilters( [
            new CharacteristicFilter( $ids ),
        ] );


        $categories = cache()->remember( 'categories.' . $key, now()->addDay(), function () use ( $city ) {
            return Category::query()->select( [ 'id', 'name', 'slug', 'parent', ] )
                           ->orderBy( 'name' )
                           ->whereHas( 'products', function ( $query ) use ( $city ) {
                               return $query->withRegion()->withCity( $city )->active();
                           } )->get();
        } );

        $cities = cache()->remember( 'cities.' . region(), now()->addDay(), function () use ( $category ) {
            return City::query()->withRegion()->select( [ 'name', 'slug' ] )
                       ->whereHas( 'products', function ( $query ) {
                           return $query->active();
                       } )->get();
        } );

        $products = cache()->remember( 'products' . $key . request( 'page', 1 ), now()->addHour(), function () use ( $products ) {
            return $products->select( 'title', 'thumbnail', 'id', 'slug', 'contact' )->with( [
                'optionValues',
                'optionValues.option'
            ] )->paginate( 12 );
        } );


        return view( 'catalog.catalog', [
            'products'      => $products,
            'category'      => $category,
            'city'          => $city,
            'cities'        => $cities,
            'categories'    => $categories->whereNull( 'parent' ),
            'subCategories' => $categories->whereNotNull( 'parent' ),
        ] );
    }
}
