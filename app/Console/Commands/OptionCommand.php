<?php

namespace App\Console\Commands;

use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class OptionCommand extends Command {

    protected $signature = 'option';


    public function handle(): void {

        Product::chunk( 10000, function ( Collection $products ) {
            foreach ( $products as $product ) {
                $ids = [];

                if ( ! $product->characteristic ) {
                    continue;
                }

                foreach ( $product->characteristic as $item ) {

                    if ( str( $item['value'] )->contains( ',' ) ) {
                        $values = explode( ',', $item['value'] );
                    } else {
                        $values = [ str( $item['value'] )->ucfirst()->trim()->value() ];
                    }


                    foreach ( $values as $value ) {
                        $option_value = OptionValue::query()->where( 'title', $value )->first();
                        if ( $option_value ) {
                            $ids[] = $option_value->id;
                        }
                    }
                }

                dump( $product->id );
                $product->optionValues()->sync( $ids );
            }
        } );


    }


    public function getOptionName( $name ): string {
        if ( str( $name )->contains( 'Год выпуска' ) ) {
            $name = 'Год выпуска';
        }

        if ( str( $name )->contains( 'Вместимость' ) ) {
            $name = 'Вместимость';
        }
        if ( str( $name )->contains( 'Тип' ) ) {
            $name = 'Тип';
        }

        if ( str( $name )->contains( 'Заказ' ) && str( $name )->contains( 'возможен' ) ) {
            $name = 'Заказ возможен';
        }
        if ( str( $name )->contains( 'Аренда' ) && str( $name )->contains( 'возможна' ) ) {
            $name = 'Аренда возможна';
        }

        return $name;
    }


    public function checkOption( $option ): bool {
        $values = [
            'Доп. условия',
        ];

        if ( str( $option )->contains( 'возможен' ) ) {
            return true;
        }
        if ( str( $option )->contains( 'Тип' ) ) {
            return true;
        }
        if ( str( $option )->contains( 'Вид' ) ) {
            return true;
        }

        if ( in_array( $option, $values ) ) {
            return true;
        }

        return false;

    }

}
