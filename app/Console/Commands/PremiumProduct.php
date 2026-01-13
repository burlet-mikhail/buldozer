<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Region;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PremiumProduct extends Command {

    protected $signature = 'launch-premium';


    public function handle(): void {

        $regions     = Region::query()->get();
        $productsIds = [];
        foreach ( $regions as $region ) {
            $products    = $region->products()->orderBy( DB::raw( 'RAND()' ) )->take( 5 )->get();
            $productsIds = array_merge( $productsIds, $products->pluck( 'id' )->toArray() );
        }

        Product::whereIn( 'id', $productsIds )->update( [
            'premium' => true,
        ] );

        dump( 'done;' );

    }
}
