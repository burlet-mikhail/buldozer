<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteImages extends Command {

    protected $signature = 'delete:images';


    public function handle(): void {
        $dirs = Storage::directories( 'public/products/original' );

        foreach ( $dirs as $dir ) {

            $folder = str( $dir )->afterLast( '/' )->value();

            $product = Product::query()->where( 'id', $folder )->first();

            if ( is_null( $product ) ) {
                Storage::deleteDirectory( $dir );
            }

            dump( $folder );
        }
    }


}
