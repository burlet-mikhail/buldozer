<?php

namespace App\Observers;

use App\Models\Region;

class CategoryObserver {

    public function created(): void {
        $this->removeCache();
    }

    public function updated(): void {
        $this->removeCache();
    }


    public function deleted(): void {
        $this->removeCache();
    }

    protected function removeCache(): void {
        cache()->forget( 'show_in_menu' );
        cache()->forget( 'show_in_popular' );
        cache()->forget( 'show_in_not_popular' );
        cache()->forget( 'categories.home' );
        cache()->forget( 'categories.add' );
        $regions = Region::query()->get();
        foreach ( $regions as $region ) {
            cache()->forget( $region->id . '.categories.home' );
        }
    }


}
