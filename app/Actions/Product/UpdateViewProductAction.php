<?php

namespace App\Actions\Product;

use App\Models\Product;

class UpdateViewProductAction {
    public function handle( Product $product ): void {

        $view = session()->get( 'viewing' );
        if ( $view !== $product->id ) {
            $product->update( [
                'viewing' => $product->viewing + 1
            ] );

            session()->put( 'viewing', $product->id );
        }
    }
}
