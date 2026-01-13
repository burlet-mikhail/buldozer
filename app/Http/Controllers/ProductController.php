<?php

namespace App\Http\Controllers;

use App\Actions\Product\UpdateViewProductAction;
use App\Models\Product;
use App\Services\Region\RegionServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Leeto\Seo\Models\Seo;

class ProductController extends Controller {
    public function show( Product $product, RegionServices $region ) {

        abort_if( $product->active = false, 404 );
        $region->set($product->region_id);
        if ( request()->fullUrl() !== route('s.products.show', [$product->region, $product])  && app()->isProduction()) {
            return  redirect()->route('s.products.show', [$product->region, $product]);
        }
        $product->load( [ 'categories', 'optionValues.option' ] );
        $productID = $product->id;
        $category  = $product->categories()->first();
        $city      = $product->cities()->first();


        $existingArray = session( 'product_view', [] );

        if ( ! in_array( $productID, $existingArray ) ) {
            $existingArray[] = $productID;
            session()->put( 'product_view', $existingArray );
        }

        $upsells = collect();
        if ( $category ) {
            $upsells = $category
                ->products()
                ->where( 'products.id', '!=', $productID )
                ->when( $city, function ( $query ) use ( $city ) {
                    $query->whereHas( 'cities', function ( $query ) use ( $city ) {
                        $query->where( 'cities.id', $city->id );
                    } );
                } )
                ->with( [ 'optionValues.option' ] )
                ->optionInCard()
                ->limit( 3 )
                ->withRegion()
                ->get();

        }


        $viewed = Product::query()
                         ->whereIn( 'id', session( 'product_view' ) )
                         ->with( [ 'optionValues.option' ] )
                         ->optionInCard()
                         ->withRegion()
                         ->limit( 3 )
                         ->get();

        ( new UpdateViewProductAction() )->handle( $product );

        return view( 'product.show', compact( 'product', 'upsells', 'viewed' ) );
    }
}
