<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\Region;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class HomeController extends Controller {
    public function __invoke(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {

        $products = cache()->rememberForever( region() . '.product.home.latest', function () {
            return Product::query()
                          ->latest()
                          ->optionInCard()
                          ->inRegion()
                          ->limit( 6 )->get();
        } );


        $premiumProducts = cache()->rememberForever( region() . '.product.home.premium', function () {
            return Product::query()
                          ->where( 'premium', true )
                          ->with( [ 'optionValues', 'optionValues.option' ] )
                          ->withRegion()
                          ->limit( 2 )
                          ->get();
        } );


        $categories = cache()->rememberForever( region() . '.categories.home', function () {
            return Category::query()->where( 'show_in_home', true )
                           ->limit( 10 )
                           ->whereHas( 'products', fn( $query ) => $query->withRegion() )
                           ->get();
        } );


        return view( 'home', compact( 'products', 'categories', 'premiumProducts' ) );
    }

    public function categoryPage(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $categories = Category::query()
                              ->whereHas( 'products', function ( $query ) {
                                  $query->region();
                              } )->paginate( 30 );

        return view( 'category', compact( 'categories' ) );
    }

    public function cityPage(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {

        $cities = City::query()->inRegion()->has( 'products' )
                      ->paginate( 30 );

        return view( 'city', compact( 'cities' ) );
    }


    public function category( Category $category ): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $products = $category->products()->paginate();

        return view( 'objects', compact( 'products' ) );
    }

    public function city( City $city ): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $products = $city->products()->paginate();

        return view( 'objects', compact( 'products' ) );
    }
}

