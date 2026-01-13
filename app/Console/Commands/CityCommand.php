<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CityCommand extends Command {

    protected $signature = 'city';


    public function handle(): void {

        Product::chunk( 10000, function ( Collection $products ) {
            foreach ( $products as $product ) {
                $city = City::query()->firstOrCreate( [
                    'name' => $product->city,
                ] );
                if ( $city->region_id ) {
                    $product->region_id = $city->region_id;
                    $product->save();
                }
                $product->cities()->sync( $city->id );

                dump( $product->id );
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
