<?php

namespace App\Filters;

use App\Models\Option;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CharacteristicFilter extends AbstractFilter {

    public function __construct( public Collection $ids ) {

    }

    public function title(): string {
        return 'Характеристики';
    }

    public function key(): string {
        return 'characteristic';
    }

    public function apply( Builder $query ): Builder {

        return $query->when( $this->requestValue(), function ( Builder $q ) {
            $q->whereHas( 'optionValues', function ( $q ) {
                $q->whereIn( 'option_value_id', $this->requestValue() );
            }, '=', count( $this->requestValue() ) );
        } );
    }

    public function values(): array|Collection {

        $id = $this->ids->pluck( 'id' )->toArray();

        $result = Option::query()
                        ->where( 'filter', true )
                        ->where( 'template', '!=', 'single_range' )
                        ->where( 'template', '!=', 'two_range' )
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
        return 'catalog.filters.characteristic';
    }
}
