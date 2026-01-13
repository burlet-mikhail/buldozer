<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use Illuminate\Console\Command;
use Leeto\Seo\Models\Seo;

class UpdateSeo extends Command {

    protected $signature = 'product:seo';


    public function handle(): void {

        $this->categorySeo();
    }


    public function citySeo(): void {
        $cities = City::query()->with( 'region' )->get();

        foreach ( $cities as $city ) {
            $keywords = [ 'Аренда', 'каталог', 'спецтехника', $city->region->name ?? '', $city->title ];


            Seo::query()->updateOrCreate( [ 'url' => $this->getRoute( 'catalog.city', $city ), ], [
                'title'       => 'Аренда спецтехники в городе ' . $city->name,
                'description' => 'Арендовать технику в городе ' . $city->name,
                'keywords'    => implode( ',', $keywords )
            ] );

            dump( 'City: ' . $city->name . ' - ' . $city->id );
        }
    }

    public function categorySeo(): void {
        $categories = Category::query()->get();

        foreach ( $categories as $category ) {
            $keywords = [ 'Аренда', 'каталог', 'спецтехника', $category->name ];
            Seo::query()->updateOrCreate( [ 'url' => $this->getRoute( 'catalog.category', $category ), ], [
                'title'       => 'Аренда ' . $category->name,
                'description' => 'Арендовать ' . $category->name,
                'keywords'    => implode( ',', $keywords )
            ] );
            dump( 'Category: ' . $category->name . ' - ' . $category->id );
        }
    }


    public function productSeo(): void {
        Product::chunk( 10000, function ( $products ) {
            foreach ( $products as $product ) {

                $title       = $product->title;
                $description = strip_tags( str( $product->text )->replace( "\n", '' )->limit( 100 )->value() );
                $keywords    = [ 'Аренда', 'каталог', 'спецтехника' ];
                foreach ( $product->cities as $city ) {
                    $keywords[] = $city->name;
                }

                foreach ( $product->categories as $category ) {
                    $keywords[] = $category->name;
                }

                Seo::query()->updateOrCreate( [ 'url' => $this->getRoute( 'products.show', $product ), ], [
                    'title'       => $title,
                    'description' => $description,
                    'keywords'    => implode( ',', $keywords )
                ] );
                dump( 'Product: ' . $product->title . ' - ' . $product->id );
            }
        } );
    }

    public function getRoute( $name, $param ): array|string {
        $route = route( $name, $param );

        return str_replace( 'http://buldozer.local', '', $route );
    }


}
