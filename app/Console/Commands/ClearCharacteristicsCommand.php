<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ClearCharacteristicsCommand extends Command {

    protected $signature = 'clear:characteristics';


    public function handle(): void {
        Product::chunk( 10000, function ( Collection $products ) {
            foreach ( $products as $product ) {
                $product->update( [
                    'characteristics' => []
                ] );
                dump( $product->id );
            }
        } );

    }
}
