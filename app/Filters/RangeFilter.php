<?php

namespace App\Filters;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RangeFilter extends AbstractFilter {

    public function __construct( public Collection $ids ) {

    }

    public function title(): string {
        return 'Характеристики';
    }

    public function key(): string {
        return 'range';
    }

    public function apply( Builder $query ): Builder {


        if ( ! $this->requestValue() ) {
            return $query;
        }

        $ids = OptionValue::query()
                          ->whereHas( 'option', function ( $query ) {
                              $query->where( 'id', $this->requestValue()['option_id'] );
                          } )
                          ->orderBy( 'title' )
                          ->whereBetween( 'title', [
                              $this->requestValue()['from'],
                              $this->requestValue()['to']
                          ] )
                          ->pluck( 'id' )->toArray();


        return $query->when( $this->requestValue(), function ( Builder $q ) use ( $ids ) {
            $q->whereHas( 'optionValues', function ( $q ) use ( $ids ) {
                $q->whereIn( 'option_value_id', $ids );
            } );
        } );
    }

    public function requestValue( string $index = null, mixed $default = null ): mixed {

        $requestValue = request( 'filters.' . $this->key() . ( $index ? ".$index" : "" ), $default );

        if ( is_array( $requestValue ) ) {

            $id = implode( '', array_keys( $requestValue ) );

            $requestValue = array_filter( $requestValue, function ( $value ) {
                return $value !== null;
            } );

            $requestValue = explode( ';', implode( $requestValue ) );

            if ( count( $requestValue ) === 2 ) {
                $requestValue = [
                    'from'      => $requestValue[0],
                    'to'        => $requestValue[1],
                    'option_id' => (int) $id
                ];
            }
        }


        return $requestValue;

    }

    public function values(): array|Collection {

        $id = $this->ids->pluck( 'id' )->toArray();


        $result = Option::query()
                        ->where( 'template', 'two_range' )
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
        return 'catalog.filters.range';
    }
}
