<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CategoryCommand extends Command {

    protected $signature = 'category';


    public function handle(): void {

        Product::chunk( 10000, function ( Collection $products ) {
            foreach ( $products as $product ) {

                $category = Category::query()->firstOrCreate( [
                    'name' => $product->category,
                ] );

                if ( $product->sub_category ) {
                    $sub_category = Category::query()->firstOrCreate( [
                        'name'   => $product->category,
                        'parent' => $category?->id ?? null
                    ] );
                    $product->categories()->sync( $sub_category->id );
                }
                $product->categories()->sync( $category->id );

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
