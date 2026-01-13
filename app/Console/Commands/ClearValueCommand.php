<?php

namespace App\Console\Commands;

use App\Models\OptionValue;
use Illuminate\Console\Command;

class ClearValueCommand extends Command {

    protected $signature = 'value';


    public function handle(): void {
        $values = OptionValue::query()->where( 'title', '0 м³' )->get();
        foreach ( $values as $value ) {
            foreach ( $value->products as $product ) {
                $product->optionValues()->detach( $value->id );
                dump( $product->id );
            }
            $value->delete();
        }
    }
}
