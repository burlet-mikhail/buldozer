<?php

use App\Http\Controllers\Api\AddController;
use App\Http\Controllers\CallbackController;
use App\Models\Product;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post( 'add_item/categories', [ AddController::class, 'getCategories' ] )
     ->name( 'add_item.categories' );
Route::post( 'add_item/categories/options/{id}', [ AddController::class, 'getOptions' ] )
     ->name( 'add_item.options' );
Route::post( 'add_item/product/{id}', [ AddController::class, 'store' ] )
     ->name( 'add_item.product' );

Route::post( 'add_item/city/{city}', [ AddController::class, 'getCity' ] )
     ->name( 'add_item.product' );

Route::post( 'callback', CallbackController::class )
     ->name( 'callback' );

Route::post( 'test', function ( Request $request ) {

    $i    = [];
    $item = $request->input( 'data' );

    $region = Region::query()->firstOrCreate( [
        'name' => $item['region'],
    ] );

    $objects = $item['list'];
    foreach ( $objects as $object ) {

        /** @var Product $product */
        $product = Product::query()->firstOrCreate( [
            'link' => $object['url'],
        ], [
            'title'        => $object['name'],
            'category'     => $item['category'] ?? null,
            'sub_category' => $item['subCategory'] ?? null,
            'city'         => $item['city'] ?? null,
            'region_id'    => $region->id,
        ] );

        $i[] = $product->id . ' - ' . $product->title;
    }

    return $i;
} );
