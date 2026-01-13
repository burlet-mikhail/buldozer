<?php


use App\Filters\FilterManager;
use App\Services\Region\RegionServices;
use Support\Flash\Flash;
use Support\Telegram;
use Support\Thumbnail\Thumbnail;

if ( ! function_exists( '__money' ) ) {
    function __money( string $money, int $countDecimal = 2, string $symbol = '₽' ): string {
        return number_format( $money, $countDecimal, '.', ' ' ) . ' ' . $symbol;
    }
}

if (!function_exists('region')) {
    function region(): int {
        return app(RegionServices::class)->getId();
    }
}

if (!function_exists('regionName')) {
    function regionName(): string {
        return app(RegionServices::class)->getName();
    }
}

if (!function_exists('regionSlug')) {
    function regionSlug(): string {
        return app(RegionServices::class)->getSlug();
    }
}

// Алиас для обратной совместимости
if (!function_exists('getSlug')) {
    function getSlug(): string {
        return regionSlug();
    }
}

if ( ! function_exists( 'telegram' ) ) {
    function telegram(): Telegram {
        return app( Telegram::class );
    }
}
if ( ! function_exists( 'trim_phone' ) ) {
    function trim_phone( string $phone ): string {
        return str( $phone )->replace( [ ' ', '(', ')', '-' ], '' )->value();
    }
}

if ( ! function_exists( 'filters' ) ) {
    function filters() {
        return app( FilterManager::class )->items();
    }
}

if ( ! function_exists( 'image' ) ) {
    function image(): Thumbnail {
        return app( Thumbnail::class );
    }
}


if ( ! function_exists( 'flash' ) ) {
    function flash(): Flash {
        return app( Flash::class );
    }
}


