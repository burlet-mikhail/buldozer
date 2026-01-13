<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductCommand extends Command {

    protected $signature = 'duplicate:product';


    public function handle(): void {

        $products = Product::query()
                           ->select( [ 'title', 'text', 'region_id' ] )
                           ->groupBy( [ 'title', 'text', 'region_id' ] )
                           ->havingRaw( 'count(title) > 1' )
                           ->havingRaw( 'count(text) > 1' )
                           ->havingRaw( 'count(region_id) > 1' )
                           ->get()->toArray();

        foreach ( $products as $index => $duplicate ) {
            $product    = Product::query()->with( 'cities' )
                                 ->where( 'title', $duplicate['title'] )
                                 ->where( 'text', $duplicate['text'] )
                                 ->where( 'region_id', $duplicate['region_id'] )
                                 ->get();
            $newProduct = new Product();
            $newProduct = $product->first();
            $cities     = [];
            foreach ( $product as $item ) {
                $cities[] = $item->cities->first()->id;
                $item->delete();
            }
            $newProduct->save();
            $newProduct->cities()->attach( $cities );
            dump( $index );
        }


//        Product::chunk( 10000, function ( $products ) {
//            foreach ( $products as $product ) {
//
//            }
//        } );
    }


}
