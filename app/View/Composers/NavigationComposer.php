<?php

namespace App\View\Composers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use App\Models\Category;
use Illuminate\View\View;

class NavigationComposer {
    public function compose( View $view ): void {
//        $menu = Menu::make()
//                    ->add( MenuItem::make( route( 'home' ), 'Главная' ) );


        $show_in_menu = cache()->remember( 'show_in_menu' . region(), now()->addDay(), function () {

            return Category::query()->where( 'show_in_menu', true )
                           ->whereHas( 'products', function ( $q ) {
                               return $q->withRegion();
                           } )->take( 3 )->inRandomOrder()->get( [ 'slug', 'name' ] );
        } );

        $show_in_popular     = cache()->remember( 'show_in_popular' . region(), now()->addDay(), function () {
            return Category::query()->where( 'show_in_popular', true )
                           ->whereHas( 'products', function ( $q ) {
                               return $q->withRegion();
                           } )->take( 10 )->inRandomOrder()->get( [ 'slug', 'name' ] );
        } );
        $show_in_not_popular = cache()->remember( 'show_in_not_popular' . region(), now()->addDay(), function () {
            return Category::query()->where( 'show_in_not_popular', true )
                           ->whereHas( 'products', function ( $q ) {
                               return $q->withRegion();
                           } )->take( 10 )->inRandomOrder()->get( [ 'slug', 'name' ] );
        } );

        $view->with( 'show_in_menu', $show_in_menu );
        $view->with( 'show_in_popular', $show_in_popular );
        $view->with( 'show_in_not_popular', $show_in_not_popular );
    }
}
