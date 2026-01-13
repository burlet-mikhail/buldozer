<?php

namespace App\Collections;


use Illuminate\Database\Eloquent\Collection;

final class ProductCollection extends Collection {
    public function keyValues(): ProductCollection {
        return $this->mapToGroups( function ( $item ) {
            return [ $item->imagesUrl => $item->images ];
        } );
    }
}
