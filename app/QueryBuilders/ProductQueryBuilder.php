<?php

namespace App\QueryBuilders;

use App\Models\Category;
use App\Models\City;
use Domain\Catalog\Facades\Sorter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;


class ProductQueryBuilder extends Builder {
    public function homePage(): ProductQueryBuilder {
        return $this->where( 'on_home_page', true )
                    ->orderBy( 'sorting' )
                    ->limit( 8 );
    }

    public function filtered() {
        return app( Pipeline::class )
            ->send( $this )->through( filters() )->thenReturn();
    }

    public function withCategory( ?Category $category ) {
        if ( ! $category ) {
            return $this;
        }

        return $this->when( $category->exists, function ( Builder $query ) use ( $category ) {
            $query->whereRelation(
                'categories',
                'categories.id',
                '=',
                $category->id );
        } );
    }

    public function withCity( ?City $city ) {

        if ( ! $city ) {
            return $this;
        }

        return $this->when( $city->exists, function ( Builder $query ) use ( $city ) {
            $query->whereRelation(
                'cities',
                'cities.id',
                '=',
                $city->id );
        } );
    }

    public function active(): ProductQueryBuilder {
        return $this;
    }

    public function withRegion(): Builder|ProductQueryBuilder {
        return $this->where( 'region_id', region() );
    }

    public function search() {
        return $this->when( request( 'search' ), function ( Builder $query ) {
            $query->whereFullText( [ 'title', 'text' ], request( 'search' ) );
        } );
    }

    public function sorted(): \Illuminate\Contracts\Database\Query\Builder {
        return Sorter::run( $this );
    }
}
