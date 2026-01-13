<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class Duplicate extends Command {

    protected $signature = 'duplicate';


    public function handle() {
        $i = 0;
        Product::chunk( 10000, function ( $products ) use ( &$i ) {
            foreach ( $products as $product ) {
                $duplicate = Product::query()
                                    ->where( 'title', $product->title )
                                    ->where( 'contact', $product->contact )
                                    ->where( 'text', $product->text )
                                    ->where( 'region_id', $product->region_id )
                                    ->count();
                if ( $duplicate > 1 ) {
                    $i = $i + $duplicate;
                }
                dump( 'ID: ' . $product->id );
                dump( 'Duplicate: ' . $i );
            }


        } );

    }
}
