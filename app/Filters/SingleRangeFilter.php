<?php

namespace App\Filters;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SingleRangeFilter extends AbstractFilter {

    public function __construct( public Collection $ids ) {

    }

    public function title(): string {
        return 'Характеристики';
    }

    public function key(): string {
        return 's_range';
    }

    public function apply( Builder $query ): Builder {


        if ( ! $this->requestValue() ) {
            return $query;
        }
        

        $ids = OptionValue::query()
                          ->whereIn( 'title', array_values( $this->requestValue() ) )
                          ->pluck( 'id' )->toArray();

        return $query->when( $this->requestValue(), function ( Builder $q ) use ( $ids ) {
            $q->whereHas( 'optionValues', function ( $q ) use ( $ids ) {
                $q->whereIn( 'option_value_id', $ids );
            }, '=', count( $ids ) );
        } );
    }

    public function values(): array|Collection {

        $id = $this->ids->pluck( 'id' )->toArray();


        $result = Option::query()
                        ->where( 'template', 'single_range' )
                        ->where( 'filter', true )
                        ->select( [ 'id', 'title', 'template' ] )
                        ->orderBy( 'template', 'desc' )
                        ->with( [
                            'optionValues' => function ( $query ) use ( $id ) {
                                $query->whereHas( 'products', function ( $subquery ) use ( $id ) {
                                    $subquery->whereIn( 'products.id', $id );
                                } )->orderBy( 'title' )
                                      ->select( [ 'option_id', 'id', 'title' ] );
                            }
                        ] )
                        ->get()
                        ->toArray();


        $result = array_filter( $result, function ( $option ) {
            return ! empty( $option['option_values'] );
        } );

        return $result;
    }

    public function view(): string {
        return 'catalog.filters.single-range';
    }
}
