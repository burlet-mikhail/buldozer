<?php

namespace App\Collections;


use Illuminate\Database\Eloquent\Collection;

final class OptionValueCollection extends Collection {
    public function keyValues() {
        return $this->mapToGroups( function ( $item ) {
            return [ $item->option->title => $item ];
        } );
    }

    public function keyValuesInCard() {
        return $this->mapToGroups( function ( $item ) {
            return [ $item->optionInCard?->title => $item ];
        } );
    }
}
