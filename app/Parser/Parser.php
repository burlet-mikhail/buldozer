<?php

namespace App\Parser;

use App\Models\Product;
use Exception;
use Goutte\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;


class Parser {
    public array|Collection $categories;

    public int $i = 0;


    public function parsePage(): void {
        Product::query()->where( 'id', '>', 30000 )->chunk( 10000, function ( $products ) {
            foreach ( $products as $product ) {
                $response = $this->getResponse( $product->link );
                if ( ! $response ) {
                    continue;
                }

                dump( $product->id );

                $this->parsePage();

                $this->i ++;

                if ( $this->i > 20 ) {
                    $this->i = 0;
                    sleep( 2 );
                }
            }
        } );
    }

    public function parseImage( $response, $product ): array {

        $data = [];
        $response->filter( '.post-photo-thumb' )->each( function ( $node ) use ( &$data, $product ) {

            if ( ! $node->count() ) {
                return true;
            }
            $link = $node->attr( 'href' );

            $data[] = self::downloadImage( $link, $product );

        } );

        if ( ! count( $data ) && $response->filter( '.post-main-photo img' )->count() ) {
            $link   = $response->filter( '.post-main-photo img' )->attr( 'src' );
            $data[] = self::downloadImage( $link, $product );
        }

        return $data;
    }

    public function get404( $response, $product ): bool {
        if ( ! $response->filter( 'h1' )->count() ) {
            return false;
        }

        if ( $response->filter( 'h1' )->text() === 'Станица не найдена / Ошибка 404' ) {
            return true;
        }

        return false;
    }


    public function parseProduct( $response, $product ): array {
        if ( ! $response->filter( 'h1' )->count() ) {
            return [];
        }
//
//        $characteristic = $this->getCharacteristic( $response );
        $phone = $response->filter( '.phones a:first-child' )->count() ? $response->filter( '.phones a:first-child' )->text() : null;
//        $text           = $response->filter( '.card-content' )->count() ? $response->filter( '.card-content' )?->html() : null;
//        $name           = $response->filter( '.phone-caption' )->count() ? $response->filter( '.phone-caption' )?->text() : null;
//        $company_name   = $response->filter( '.hide-in-premium' )->count() ? $response->filter( '.hide-in-premium' )?->text() : null;
//
//        $text = str( $text )->replace( '<a href="#" class="read-more">Посмотреть полностью</a>', ' ' );
//
//        $messenger = [];
//        if ( $response->filter( '.whatsapp-link' )->count() ) {
//            $whatsapp              = $response->filter( '.whatsapp-link' )->attr( 'href' );
//            $whatsapp              = preg_replace( '/[^0-9+]/', '', $whatsapp );
//            $messenger['whatsapp'] = $whatsapp;
//        }
//        if ( $response->filter( '.telegram-link' )->count() ) {
//            $telegram              = $response->filter( '.telegram-link' )->attr( 'href' );
//            $telegram              = preg_replace( '/[^0-9+]/', '', $telegram );
//            $messenger['telegram'] = $telegram;
//        }
//        if ( $response->filter( '.viber-link' )->count() ) {
//            $viber                 = $response->filter( '.viber-link' )->attr( 'href' );
//            $viber                 = preg_replace( '/[^0-9+]/', '', $viber );
//            $messenger['telegram'] = $viber;
//        }

        $productData = [
            'contact' => $phone,

//            'text'           => $text,
//            'name'           => $name,
//            'company_name'   => $company_name,
//            'characteristic' => $characteristic,
//            'thumbnail'      => $this->parseImage( $response, $product ),
//            'messenger'      => $messenger,
//            'success'        => true,
        ];

        $this->addProduct( $productData, $product );

        return $productData;
    }

    public function addProduct( $productData, $product ): void {
        $product->update( $productData );
    }

    public function getResponse( $link ): ?Crawler {
        $client   = new Client();
        $response = null;
        try {
            $response = $client->request( 'GET', $link );
        } catch ( Exception $exception ) {
            info( $exception->getMessage() );
        }

        return $response;
    }

    public function downloadImage( $url, $product ): string {
        $savePath = 'products/original/' . $product->id . '/'; // Путь сохранения изображения в папке Laravel (предполагается, что папка уже создана)

        try {
            $imageContents = file_get_contents( $url );
        } catch ( Exception $exception ) {
            dump( $exception->getMessage() );

            return '';
        }

        $fileName = uniqid() . '.' . pathinfo( $url, PATHINFO_EXTENSION );

        $filePath = $savePath . $fileName;

        Storage::put( 'public/' . $filePath, $imageContents );

        return $filePath;
    }


    public function getCharacteristic( $response ): array {
        $char = [];

        if ( ! $response->filter( '.attr-group' )->count() ) {
            return $char;
        }

        $response->filter( '.attr-group' )->each( function ( $item ) use ( &$char ) {
            $char[] = [
                'name'  => $item->filter( '.attr-label' )->text(),
                'value' => $item->filter( '.attr-value' )->text()
            ];
        } );

        return $char;
    }


}


