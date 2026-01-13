<?php

namespace App\View\Composers;

use App\Models\Region;
use Illuminate\View\View;

class RegionComposer {


    public function compose( View $view ): void {
        $regions = cache()->rememberForever( 'regions.modal', function () {
            $regions = Region::query()->with( 'cities' )
                             ->orderBy( 'name' )
                             ->get( [
                                 'slug',
                                 'name',
                                 'id'
                             ] );

            return $regions->groupBy( function ( $region ) {
                // Получаем первую букву в названии региона
                $firstCharacter = mb_substr( $region['name'], 0, 1 );

                // Возвращаем только первую букву для группировки
                return $firstCharacter;
            } )->map( function ( $regionsInGroup, $letter ) {
                // Возвращаем массив с ключом 'letter' и группой регионов без ключа 'letter'
                return [
                    'letter'  => $letter,
                    'regions' => $regionsInGroup,
                ];
            } );

        } );

        $moscow = cache()->rememberForever( 'moscow', function () {
            return Region::query()->with( 'cities' )->where( 'name', 'Москва' )->first();
        } );

        $view->with( 'regions', $regions );
        $view->with( 'moscow', $moscow );
    }
}
