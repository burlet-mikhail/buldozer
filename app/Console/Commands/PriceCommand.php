<?php

namespace App\Console\Commands;

use App\Models\Option;
use Illuminate\Console\Command;

class PriceCommand extends Command {

    protected $signature = 'price';


    public function handle(): void {
        $option = Option::query()->where( 'title', 'Аренда, цена' )->first();


        foreach ( $option->optionValues as $item ) {
            dump( $item->title );
            foreach ( $item->products as $product ) {
                $product->update( [
                    'price' => $item->title
                ] );
                dump( $product->id );
            }

        }
    }
}
